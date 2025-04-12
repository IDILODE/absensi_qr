import sys
import json
from pyannote.audio.pipelines import SpeakerIdentification
from pyannote.core import Segment
import torch

def verify_speaker(audio_file_path, model_path='models/speaker_recognition_model'):
    # Load pretrained model
    model = SpeakerIdentification.from_pretrained(model_path)

    # Process audio file to extract features
    audio = torch.load(audio_file_path)  # Load audio file
    speaker = model({"uri": "filename", "audio": audio})  # Identifikasi speaker

    return speaker

def main():
    if len(sys.argv) != 2:
        print(json.dumps({"status": "error", "message": "Invalid arguments"}))
        sys.exit(1)

    suara_file = sys.argv[1]

    # Verifikasi suara
    try:
        result = verify_speaker(suara_file)
        if result:
            print(json.dumps({"status": "success", "message": "Speaker verified successfully"}))
        else:
            print(json.dumps({"status": "error", "message": "Speaker verification failed"}))
    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))

if __name__ == '__main__':
    main()
