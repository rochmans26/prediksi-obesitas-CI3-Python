import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import classification_report, accuracy_score
import joblib

# 1. Load dataset
df = pd.read_csv("../ml/dataset/obesity_dataset.csv")  # Ganti dengan path sesuai lokasi file kamu

# 2. Pisahkan fitur dan target
X = df.drop(columns=["Class"])
y = df["Class"]

# 3. Bagi data menjadi training dan testing
X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42
)

# 4. Buat dan latih model Random Forest
model = RandomForestClassifier(random_state=42)
model.fit(X_train, y_train)

# 5. Evaluasi model
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
report = classification_report(y_test, y_pred)

print(f"Accuracy: {accuracy:.2f}")
print("Classification Report:")
print(report)

# 6. Simpan model ke file
joblib.dump(model, "obesity_model.pkl")
print("Model disimpan sebagai 'obesity_model.pkl'")