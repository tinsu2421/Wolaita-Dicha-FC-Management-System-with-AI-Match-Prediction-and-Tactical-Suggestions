from flask import Flask, render_template, request
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix, log_loss, brier_score_loss
import numpy as np
import joblib
import os
from datetime import datetime

app = Flask(__name__)

RECENT_CSV = "wolaita_dicha_recent_match.csv"
FUTURE_CSV = "future_matches.csv"
TEAM_NAME = "Wolaita Dicha"

# Model and encoder file paths
MODEL_PATH = "models/wolaita_dicha_model.pkl"
ENCODER_PATH = "models/wolaita_dicha_encoder.pkl"
METRICS_PATH = "models/model_metrics.pkl"

# Create models directory if it doesn't exist
os.makedirs("models", exist_ok=True)

# Global variables for model metrics
model_accuracy = 0
model_report = {}
confusion_mat = []
log_loss_score = 0
brier_score_avg = 0
brier_scores_by_class = {}

# Global variables to store model metrics
model_accuracy = None
model_report = None
confusion_mat = None

# -------------------------
# Model Persistence Functions
# -------------------------
def save_model(model, encoder, metrics):
    """Save trained model, encoder, and metrics using Joblib"""
    try:
        joblib.dump(model, MODEL_PATH)
        joblib.dump(encoder, ENCODER_PATH)
        joblib.dump(metrics, METRICS_PATH)
        print(f"✅ Model saved to {MODEL_PATH}")
        print(f"✅ Encoder saved to {ENCODER_PATH}")
        print(f"✅ Metrics saved to {METRICS_PATH}")
        return True
    except Exception as e:
        print(f"❌ Error saving model: {e}")
        return False

def load_model():
    """Load saved model, encoder, and metrics using Joblib"""
    try:
        if os.path.exists(MODEL_PATH) and os.path.exists(ENCODER_PATH) and os.path.exists(METRICS_PATH):
            model = joblib.load(MODEL_PATH)
            encoder = joblib.load(ENCODER_PATH)
            metrics = joblib.load(METRICS_PATH)
            print(f"✅ Model loaded from {MODEL_PATH}")
            print(f"✅ Encoder loaded from {ENCODER_PATH}")
            print(f"✅ Metrics loaded from {METRICS_PATH}")
            return model, encoder, metrics
        else:
            print("📝 No saved model found. Will train new model.")
            return None, None, None
    except Exception as e:
        print(f"❌ Error loading model: {e}")
        return None, None, None

def should_retrain_model():
    """Check if model should be retrained based on data freshness"""
    if not os.path.exists(MODEL_PATH):
        return True
    
    # Check if CSV file is newer than saved model
    csv_modified = os.path.getmtime(RECENT_CSV)
    model_modified = os.path.getmtime(MODEL_PATH)
    
    if csv_modified > model_modified:
        print("📊 Data has been updated. Retraining model...")
        return True
    
    return False

# -------------------------
# Load Data
# -------------------------
def load_recent():
    df = pd.read_csv(RECENT_CSV)

    numeric_cols = ["Goals_For", "Goals_Against", "Shots", "Possession"]
    for col in numeric_cols:
        df[col] = pd.to_numeric(df[col], errors="coerce").fillna(0)

    df["HomeAway"] = df["HomeAway"].map({"Home": 1, "Away": 0})
    df = df.dropna(subset=["Result"])
    return df

def load_future():
    df = pd.read_csv(FUTURE_CSV)
    return df.to_dict(orient="records")

# -------------------------
# Train Model with Historical Data Only
# -------------------------
def train_model(df):
    global model_accuracy, model_report, confusion_mat, log_loss_score, brier_score_avg, brier_scores_by_class
    
    # Try to load existing model first if data hasn't changed
    if not should_retrain_model():
        model, le, metrics = load_model()
        if model is not None and le is not None and metrics is not None:
            print("🚀 Using saved model (no retraining needed)")
            # Update global variables with loaded metrics
            model_accuracy = metrics['accuracy']
            model_report = metrics['classification_report']
            confusion_mat = metrics['confusion_matrix']
            log_loss_score = metrics['log_loss']
            brier_score_avg = metrics['brier_score_avg']
            brier_scores_by_class = metrics['brier_scores_by_class']
            return model, le
    
    print("🔄 Training new model...")
    print(f"📅 Training started at: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    
    le = LabelEncoder()
    df["Result_Label"] = le.fit_transform(df["Result"])
    
    # Calculate rolling averages for last 5 matches
    df['Avg_Goals_For_5'] = df['Goals_For'].rolling(window=5, min_periods=1).mean()
    df['Avg_Goals_Against_5'] = df['Goals_Against'].rolling(window=5, min_periods=1).mean()
    df['Avg_Shots_5'] = df['Shots'].rolling(window=5, min_periods=1).mean()
    df['Avg_Possession_5'] = df['Possession'].rolling(window=5, min_periods=1).mean()
    
    # Use only historical averages and home/away for prediction
    features = [
        "Avg_Goals_For_5", "Avg_Goals_Against_5", "Avg_Shots_5", "Avg_Possession_5",  # Historical averages
        "HomeAway"  # Home/Away advantage
    ]
    X = df[features]
    y = df["Result_Label"]

    # Split data into training and testing sets (80% train, 20% test)
    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=0.2, random_state=42, stratify=y
    )

    # Train the model
    model = RandomForestClassifier(n_estimators=300, max_depth=6, random_state=42)
    model.fit(X_train, y_train)
    
    # Make predictions on test set
    y_pred = model.predict(X_test)
    y_pred_proba = model.predict_proba(X_test)
    
    # Calculate accuracy
    model_accuracy = accuracy_score(y_test, y_pred)
    
    # Calculate Log Loss
    log_loss_score = log_loss(y_test, y_pred_proba)
    
    # Calculate Brier Score for each class (multiclass)
    brier_scores_by_class = {}
    classes = le.classes_
    
    for i, class_name in enumerate(classes):
        # Convert to binary classification (current class vs rest)
        y_binary = (y_test == i).astype(int)
        y_prob_binary = y_pred_proba[:, i]
        brier_score = brier_score_loss(y_binary, y_prob_binary)
        brier_scores_by_class[class_name] = brier_score
    
    # Average Brier Score across all classes
    brier_score_avg = np.mean(list(brier_scores_by_class.values()))
    
    # Generate classification report
    model_report = classification_report(
        y_test, y_pred, 
        target_names=le.classes_, 
        output_dict=True
    )
    
    # Generate confusion matrix and convert to list for template
    confusion_mat = confusion_matrix(y_test, y_pred).tolist()
    
    # Prepare metrics for saving
    metrics = {
        'accuracy': model_accuracy,
        'classification_report': model_report,
        'confusion_matrix': confusion_mat,
        'log_loss': log_loss_score,
        'brier_score_avg': brier_score_avg,
        'brier_scores_by_class': brier_scores_by_class,
        'training_date': datetime.now().isoformat(),
        'training_samples': len(X_train),
        'test_samples': len(X_test)
    }
    
    # Save the trained model, encoder, and metrics
    save_success = save_model(model, le, metrics)
    if save_success:
        print("💾 Model successfully saved for future use")
    else:
        print("⚠️ Model training completed but saving failed")
    
    # Print detailed performance metrics
    print("\n" + "="*70)
    print("MODEL PERFORMANCE METRICS")
    print("="*70)
    print(f"Training Set Size: {len(X_train)} samples")
    print(f"Test Set Size: {len(X_test)} samples")
    print(f"\nAccuracy: {model_accuracy * 100:.2f}%")
    print(f"Log Loss: {log_loss_score:.4f}")
    print(f"Average Brier Score: {brier_score_avg:.4f}")
    
    print(f"\nBrier Score by Class:")
    for class_name, score in brier_scores_by_class.items():
        print(f"  {class_name}: {score:.4f}")
    
    print(f"\nMetric Interpretation:")
    print(f"• Log Loss: Lower is better (0 = perfect, higher = worse)")
    print(f"• Brier Score: Lower is better (0 = perfect, 1 = worst)")
    print(f"• Good Log Loss: < 0.5, Excellent: < 0.2")
    print(f"• Good Brier Score: < 0.2, Excellent: < 0.1")
    
    print("\nClassification Report:")
    print(classification_report(y_test, y_pred, target_names=le.classes_))
    print("\nConfusion Matrix:")
    print(confusion_matrix(y_test, y_pred))
    print("="*70 + "\n")
    print(f"🎯 Training completed at: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    
    return model, le

# -------------------------
# Get team's recent form (last 5 matches averages)
# -------------------------
def get_recent_form(df):
    recent = df.tail(5)
    return {
        "Avg_Goals_For_5": recent["Goals_For"].mean(),
        "Avg_Goals_Against_5": recent["Goals_Against"].mean(),
        "Avg_Shots_5": recent["Shots"].mean(),
        "Avg_Possession_5": recent["Possession"].mean()
    }

# -------------------------
# Convert probability to odds
# -------------------------
def prob_to_odds(p):
    return round(1 / p, 2) if p > 0 else None

# -------------------------
# Advanced Tactical Advice Based on Historical Performance
# -------------------------
def tactical_advice_advanced(recent_form, prediction, is_home):
    advice = []

    # Strategy based on predicted win %
    if prediction["win_pct"] < 35:
        advice.append("Play defensively; prioritize counter-attacks")
    elif prediction["win_pct"] > 55:
        advice.append("High pressing and aggressive attacking style")
    else:
        advice.append("Balanced approach; maintain control and adaptability")

    # Home/Away logic
    if is_home:
        advice.append("Use home advantage to control tempo and exploit set-pieces")
    else:
        advice.append("Stay compact, avoid mistakes, exploit counter-attacks")

    # Historical performance-based advice
    if recent_form["Avg_Goals_Against_5"] > recent_form["Avg_Goals_For_5"]:
        advice.append("Strengthen defensive organization based on recent form")
    if recent_form["Avg_Shots_5"] < 8:
        advice.append("Create more shooting opportunities; improve attacking transitions")
    if recent_form["Avg_Possession_5"] < 45:
        advice.append("Improve midfield control; focus on ball retention")
    if recent_form["Avg_Possession_5"] > 60 and recent_form["Avg_Goals_For_5"] < 1.2:
        advice.append("Convert possession dominance into effective scoring chances")

    # Risk meter
    risk = "Moderate"
    if prediction["win_pct"] > 60:
        risk = "Low"
    elif prediction["win_pct"] < 30:
        risk = "High"

    advice.append(f"Risk Level: {risk}")

    return " • ".join(advice)

# -------------------------
# Get Model Information
# -------------------------
def get_model_info():
    """Get information about the saved model"""
    if os.path.exists(MODEL_PATH):
        model_stats = os.stat(MODEL_PATH)
        model_size = model_stats.st_size / 1024  # Size in KB
        model_modified = datetime.fromtimestamp(model_stats.st_mtime)
        
        return {
            'exists': True,
            'size_kb': round(model_size, 2),
            'last_trained': model_modified.strftime('%Y-%m-%d %H:%M:%S'),
            'path': MODEL_PATH
        }
    return {'exists': False}

# -------------------------
# Routes
# -------------------------
@app.route("/", methods=["GET", "POST"])
def index():
    recent_df = load_recent()
    future_matches = load_future()
    
    # Get model information
    model_info = get_model_info()
    
    # Train or load model
    model, le = train_model(recent_df)

    # Get recent form for predictions
    recent_form = get_recent_form(recent_df)
    
    prediction = None
    advice = None
    win_prob_dict = None
    odds_dict = None

    if request.method == "POST":
        match_id = request.form.get("match_id")
        match = next(m for m in future_matches if str(m["id"]) == match_id)

        is_home = 1 if match["Home"] == TEAM_NAME else 0
        opponent = match["Away"] if is_home else match["Home"]

        # Use only historical averages and home/away for prediction (no user input)
        X_new = pd.DataFrame([{
            "Avg_Goals_For_5": recent_form["Avg_Goals_For_5"],
            "Avg_Goals_Against_5": recent_form["Avg_Goals_Against_5"],
            "Avg_Shots_5": recent_form["Avg_Shots_5"],
            "Avg_Possession_5": recent_form["Avg_Possession_5"],
            "HomeAway": is_home
        }])

        probs = model.predict_proba(X_new)[0]
        classes = le.inverse_transform(model.classes_)
        prob_map = dict(zip(classes, probs))

        win_p = prob_map.get("W", 0)
        draw_p = prob_map.get("D", 0)
        loss_p = prob_map.get("L", 0)

        prediction = {
            "match_date": match["Date"],
            "opponent": opponent,
            "home_away": "Home" if is_home else "Away",
            "win_pct": round(win_p * 100, 2),
            "draw_pct": round(draw_p * 100, 2),
            "loss_pct": round(loss_p * 100, 2),
            "win_odds": prob_to_odds(win_p),
            "draw_odds": prob_to_odds(draw_p),
            "loss_odds": prob_to_odds(loss_p),
            "final": max(prob_map, key=prob_map.get)
        }

        # Generate tactical advice
        advice = tactical_advice_advanced(
            recent_form=recent_form,
            prediction=prediction,
            is_home=is_home
        )

        # Prepare dictionaries for frontend
        win_prob_dict = {
            "Win": prediction["win_pct"],
            "Draw": prediction["draw_pct"],
            "Loss": prediction["loss_pct"]
        }
        odds_dict = {
            "Win": prediction["win_odds"],
            "Draw": prediction["draw_odds"],
            "Loss": prediction["loss_odds"]
        }

    return render_template(
        "main2.html",
        future_matches=future_matches,
        prediction=prediction,
        advice=advice,
        win_prob_dict=win_prob_dict,
        odds_dict=odds_dict,
        recent_form=recent_form,
        model_accuracy=model_accuracy,
        model_report=model_report,
        confusion_mat=confusion_mat,
        log_loss_score=log_loss_score,
        brier_score_avg=brier_score_avg,
        brier_scores_by_class=brier_scores_by_class,
        model_info=model_info
    )

@app.route("/retrain", methods=["POST"])
def retrain_model():
    """Force retrain the model"""
    try:
        # Remove existing model files to force retraining
        if os.path.exists(MODEL_PATH):
            os.remove(MODEL_PATH)
        if os.path.exists(ENCODER_PATH):
            os.remove(ENCODER_PATH)
        if os.path.exists(METRICS_PATH):
            os.remove(METRICS_PATH)
        
        print("🔄 Forced model retraining initiated...")
        return {"status": "success", "message": "Model will be retrained on next request"}
    except Exception as e:
        return {"status": "error", "message": str(e)}

if __name__ == "__main__":
    print("🚀 Starting Wolaita Dicha FC Match Prediction System")
    print(f"📊 Model will be saved to: {MODEL_PATH}")
    print(f"🔧 Using Joblib for model persistence")
    app.run(debug=True, port=5002)
