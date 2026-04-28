#!/usr/bin/env python3
"""
Test script to verify Joblib model saving and loading functionality
"""

import pandas as pd
import os
import sys

# Add current directory to path to import main2 functions
sys.path.append('.')

def test_joblib_integration():
    """Test the Joblib model saving and loading functionality"""
    print("🧪 Testing Joblib Model Integration")
    print("=" * 50)
    
    try:
        # Import functions from main2
        from main2 import load_recent, train_model, get_model_info, MODEL_PATH, ENCODER_PATH, METRICS_PATH
        
        print("✅ Successfully imported main2 functions")
        
        # Test 1: Load data
        print("\n📊 Test 1: Loading data...")
        recent_df = load_recent()
        print(f"✅ Loaded {len(recent_df)} records from CSV")
        
        # Test 2: Train model (should save with Joblib)
        print("\n🔄 Test 2: Training model with Joblib saving...")
        model, encoder = train_model(recent_df)
        print("✅ Model training completed")
        
        # Test 3: Check if files were created
        print("\n📁 Test 3: Checking saved files...")
        files_to_check = [
            (MODEL_PATH, "Model file"),
            (ENCODER_PATH, "Encoder file"), 
            (METRICS_PATH, "Metrics file")
        ]
        
        all_files_exist = True
        for file_path, description in files_to_check:
            if os.path.exists(file_path):
                file_size = os.path.getsize(file_path) / 1024  # Size in KB
                print(f"✅ {description}: {file_path} ({file_size:.2f} KB)")
            else:
                print(f"❌ {description}: {file_path} (NOT FOUND)")
                all_files_exist = False
        
        # Test 4: Get model info
        print("\n📋 Test 4: Getting model information...")
        model_info = get_model_info()
        if model_info['exists']:
            print(f"✅ Model exists: {model_info['size_kb']} KB")
            print(f"✅ Last trained: {model_info['last_trained']}")
        else:
            print("❌ Model info indicates model doesn't exist")
            all_files_exist = False
        
        # Test 5: Test loading saved model
        print("\n📥 Test 5: Testing model loading...")
        from main2 import load_model
        loaded_model, loaded_encoder, loaded_metrics = load_model()
        
        if loaded_model is not None and loaded_encoder is not None:
            print("✅ Model and encoder loaded successfully from Joblib files")
            print(f"✅ Model type: {type(loaded_model).__name__}")
            print(f"✅ Encoder type: {type(loaded_encoder).__name__}")
            
            if loaded_metrics:
                print(f"✅ Loaded metrics - Accuracy: {loaded_metrics['accuracy']:.4f}")
                print(f"✅ Training date: {loaded_metrics.get('training_date', 'Unknown')}")
        else:
            print("❌ Failed to load model from Joblib files")
            all_files_exist = False
        
        # Test 6: Test prediction with loaded model
        print("\n🎯 Test 6: Testing prediction with loaded model...")
        try:
            # Create sample prediction data
            sample_data = pd.DataFrame([{
                "Avg_Goals_For_5": 1.5,
                "Avg_Goals_Against_5": 1.2,
                "Avg_Shots_5": 12.0,
                "Avg_Possession_5": 55.0,
                "HomeAway": 1
            }])
            
            prediction = loaded_model.predict_proba(sample_data)[0]
            classes = loaded_encoder.inverse_transform(loaded_model.classes_)
            
            print("✅ Prediction successful:")
            for i, class_name in enumerate(classes):
                print(f"   {class_name}: {prediction[i]*100:.2f}%")
                
        except Exception as e:
            print(f"❌ Prediction failed: {e}")
            all_files_exist = False
        
        # Final result
        print("\n" + "=" * 50)
        if all_files_exist:
            print("🎉 ALL TESTS PASSED!")
            print("✅ Joblib integration is working correctly")
            print("✅ Model persistence is functional")
            print("✅ Ready for production use")
        else:
            print("❌ SOME TESTS FAILED!")
            print("⚠️ Check the error messages above")
        
        print("=" * 50)
        
    except ImportError as e:
        print(f"❌ Import error: {e}")
        print("Make sure main2.py is in the current directory")
    except Exception as e:
        print(f"❌ Test failed with error: {e}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    test_joblib_integration()