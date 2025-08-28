import pandas as pd
from flask import Flask, request, jsonify
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.neighbors import KNeighborsClassifier
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score
import os
import joblib

app = Flask(__name__)

# File path
DATA_FILE = 'dataset/obesity_dataset.csv'
MODEL_KNN_FILE = 'knn_model.pkl'
MODEL_RF_FILE = 'rf_model.pkl'
SCALER_FILE = 'scaler.pkl'

# Load or initialize dataset
def load_data():
    if os.path.exists(DATA_FILE):
        return pd.read_csv(DATA_FILE)
    return None

# Preprocess data
def preprocess_data(df):
    X = df.drop('Class', axis=1)
    y = df['Class']
    
    # Split data
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    
    # Scale features
    scaler = StandardScaler()
    X_train_scaled = scaler.fit_transform(X_train)
    X_test_scaled = scaler.transform(X_test)
    
    return X_train_scaled, X_test_scaled, y_train, y_test, scaler

# Train and evaluate models
def train_and_evaluate():
    df = load_data()
    if df is None:
        return {"error": "Dataset not found"}, 404
    
    X_train_scaled, X_test_scaled, y_train, y_test, scaler = preprocess_data(df)
    
    # Train KNN
    knn = KNeighborsClassifier(n_neighbors=5)
    knn.fit(X_train_scaled, y_train)
    y_pred_knn = knn.predict(X_test_scaled)
    
    # Train Random Forest
    rf = RandomForestClassifier(n_estimators=100, random_state=42)
    rf.fit(X_train_scaled, y_train)
    y_pred_rf = rf.predict(X_test_scaled)
    
    # Evaluate models
    metrics = {
        'KNN': {
            'accuracy': accuracy_score(y_test, y_pred_knn),
            'precision': precision_score(y_test, y_pred_knn, average='weighted'),
            'recall': recall_score(y_test, y_pred_knn, average='weighted'),
            'f1': f1_score(y_test, y_pred_knn, average='weighted')
        },
        'Random Forest': {
            'accuracy': accuracy_score(y_test, y_pred_rf),
            'precision': precision_score(y_test, y_pred_rf, average='weighted'),
            'recall': recall_score(y_test, y_pred_rf, average='weighted'),
            'f1': f1_score(y_test, y_pred_rf, average='weighted')
        }
    }
    
    # Save models and scaler
    joblib.dump(knn, MODEL_KNN_FILE)
    joblib.dump(rf, MODEL_RF_FILE)
    joblib.dump(scaler, SCALER_FILE)
    
    return metrics

# API Endpoints
@app.route('/api/predict', methods=['POST'])
def predict():
    data = request.json
    if not data:
        return jsonify({"error": "No data provided"}), 400
    
    try:
        # Load models and scaler
        knn = joblib.load(MODEL_KNN_FILE)
        rf = joblib.load(MODEL_RF_FILE)
        scaler = joblib.load(SCALER_FILE)
        
        # Prepare input data
        input_data = pd.DataFrame([data])
        scaled_data = scaler.transform(input_data)
        
        # Make predictions
        knn_pred = int(knn.predict(scaled_data)[0])
        rf_pred = int(rf.predict(scaled_data)[0])
        
        return jsonify({
            'KNN_prediction': knn_pred,
            'RandomForest_prediction': rf_pred
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/api/metrics', methods=['GET'])
def get_metrics():
    try:
        metrics = train_and_evaluate()
        return jsonify(metrics)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/api/data', methods=['GET', 'POST', 'PUT', 'DELETE'])
def handle_data():
    # Definisikan kolom-kolom integer Anda
    INT_COLUMNS = [
        'Sex', 'Age', 'Height', 'Weight', 'Overweight_Obese_Family',
        'Consumption_of_Fast_Food', 'Frequency_of_Consuming_Vegetables',
        'Number_of_Main_Meals_Daily', 'Food_Intake_Between_Meals',
        'Smoking', 'Liquid_Intake_Daily', 'Calculation_of_Calorie_Intake',
        'Physical_Exercise', 'Schedule_Dedicated_to_Technology',
        'Type_of_Transportation_Used', 'Class'
    ]

    def validate_int(value, col_name):
        """Validasi dan konversi ke integer dengan error handling"""
        try:
            return int(value)
        except (ValueError, TypeError):
            raise ValueError(f"Invalid integer value for {col_name}")

    if request.method == 'GET':
        df = load_data()
        if df is None:
            return jsonify({"error": "Dataset not found"}), 404
        return jsonify(df.to_dict(orient='records'))

    elif request.method == 'POST':
        data = request.json
        if not data:
            return jsonify({"error": "No data provided"}), 400

        # Validasi semua kolom required ada
        missing_cols = [col for col in INT_COLUMNS if col not in data]
        if missing_cols:
            return jsonify({"error": f"Missing columns: {missing_cols}"}), 400

        # Konversi semua nilai ke integer
        try:
            new_data = {col: validate_int(data[col], col) for col in INT_COLUMNS}
        except ValueError as e:
            return jsonify({"error": str(e)}), 400

        df = load_data() or pd.DataFrame(columns=INT_COLUMNS)
        df = pd.concat([df, pd.DataFrame([new_data])], ignore_index=True)
        df.to_csv(DATA_FILE, index=False)
        return jsonify({"message": "Data added successfully", "index": len(df)-1}), 201

    elif request.method == 'PUT':
        data = request.json
        if not data or 'index' not in data:
            return jsonify({"error": "Index and data must be provided"}), 400

        df = load_data()
        if df is None:
            return jsonify({"error": "Dataset not found"}), 404

        try:
            idx = int(data.pop('index'))
            if idx < 0 or idx >= len(df):
                return jsonify({"error": "Invalid index"}), 400
        except ValueError:
            return jsonify({"error": "Index must be an integer"}), 400

        # Konversi dan validasi data
        try:
            updates = {col: validate_int(data[col], col) for col in data if col in INT_COLUMNS}
        except ValueError as e:
            return jsonify({"error": str(e)}), 400

        # Apply updates
        for col, val in updates.items():
            df.at[idx, col] = val

        df.to_csv(DATA_FILE, index=False)
        return jsonify({"message": "Data updated successfully"})

    elif request.method == 'DELETE':
        data = request.json
        if not data or 'index' not in data:
            return jsonify({"error": "Index must be provided"}), 400

        df = load_data()
        if df is None:
            return jsonify({"error": "Dataset not found"}), 404

        try:
            idx = int(data['index'])
            if idx < 0 or idx >= len(df):
                return jsonify({"error": "Invalid index"}), 400
        except ValueError:
            return jsonify({"error": "Index must be an integer"}), 400

        df = df.drop(index=idx).reset_index(drop=True)
        df.to_csv(DATA_FILE, index=False)
        return jsonify({"message": "Data deleted successfully"})

# @app.route('/api/data', methods=['GET', 'POST', 'PUT', 'DELETE'])
# def handle_data():
#     if request.method == 'GET':
#         # Get all data
#         df = load_data()
#         if df is None:
#             return jsonify({"error": "Dataset not found"}), 404
#         return jsonify(df.to_dict(orient='records'))
    
#     elif request.method == 'POST':
#         # Add new data
#         data = request.json
#         if not data:
#             return jsonify({"error": "No data provided"}), 400
        
#         df = load_data()
#         if df is None:
#             df = pd.DataFrame(columns=data.keys())
        
#         new_df = pd.concat([df, pd.DataFrame([data])], ignore_index=True)
#         new_df.to_csv(DATA_FILE, index=False)
#         return jsonify({"message": "Data added successfully"}), 201
    
#     elif request.method == 'PUT':
#         # Update data
#         data = request.json
#         if not data or 'index' not in data:
#             return jsonify({"error": "Index and data must be provided"}), 400
        
#         df = load_data()
#         if df is None:
#             return jsonify({"error": "Dataset not found"}), 404
        
#         idx = data.pop('index')
#         if idx < 0 or idx >= len(df):
#             return jsonify({"error": "Invalid index"}), 400
        
#         for col, val in data.items():
#             if col in df.columns:
#                 df.at[idx, col] = val
        
#         df.to_csv(DATA_FILE, index=False)
#         return jsonify({"message": "Data updated successfully"})
    
#     elif request.method == 'DELETE':
#         # Delete data
#         data = request.json
#         if not data or 'index' not in data:
#             return jsonify({"error": "Index must be provided"}), 400
        
#         df = load_data()
#         if df is None:
#             return jsonify({"error": "Dataset not found"}), 404
        
#         idx = data['index']
#         if idx < 0 or idx >= len(df):
#             return jsonify({"error": "Invalid index"}), 400
        
#         df = df.drop(index=idx).reset_index(drop=True)
#         df.to_csv(DATA_FILE, index=False)
#         return jsonify({"message": "Data deleted successfully"})

if __name__ == '__main__':
    # Initial training
    train_and_evaluate()
    app.run(debug=True, port=5000)