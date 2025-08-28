from flask import Flask, request, jsonify
import joblib
import pandas as pd
# from sklearn.model_selection import train_test_split
# from sklearn.ensemble import RandomForestClassifier
# from sklearn.neighbors import KNearestNeighborsClassifier
# from sklearn.metrics import accuracy_score
# import time

app = Flask(__name__)

# Load model
model = joblib.load("obesity_model.pkl")

# Fitur yang dibutuhkan
columns = [
    "Sex", "Age", "Height", "Overweight_Obese_Family",
    "Consumption_of_Fast_Food", "Frequency_of_Consuming_Vegetables",
    "Number_of_Main_Meals_Daily", "Food_Intake_Between_Meals",
    "Smoking", "Liquid_Intake_Daily", "Calculation_of_Calorie_Intake",
    "Physical_Excercise", "Schedule_Dedicated_to_Technology",
    "Type_of_Transportation_Used"
]

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.json
        input_data = [data[col] for col in columns]
        df = pd.DataFrame([input_data], columns=columns)
        prediction = int(model.predict(df)[0])
        return jsonify({"prediction": prediction})
    except Exception as e:
        return jsonify({"error": str(e)})

# @app.route('/compare', method=['POST'])
# def compare():
#     return 0


if __name__ == '__main__':
    app.run(debug=True)
