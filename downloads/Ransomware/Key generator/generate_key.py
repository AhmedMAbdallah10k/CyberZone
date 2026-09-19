from Crypto.Random import get_random_bytes
import os
import datetime
import sys

def save_key(key, filename):
    with open(filename, "w") as key_file:  # Use 'w' to write text
        key_file.write(key.hex())  # Convert bytes to hexadecimal string

if __name__ == "__main__":
    key = get_random_bytes(32)  # Generate a secure 32-byte key
    # generation_path = os.path.join(os.environ['USERPROFILE'], 'Desktop')  # Get the desktop path
    if getattr(sys, 'frozen', False):  # If running as an executable
        generation_path = os.path.dirname(sys.executable)  # Get the directory of the executable
    else:  # If running as a script
        generation_path = os.path.dirname(os.path.abspath(__file__))  # Get the directory of the current script

    timestamp = datetime.datetime.now().strftime("%Y%m%d_%H%M%S")  # Get current timestamp
    key_filename = os.path.join(generation_path, f"encryption_key_{timestamp}.txt")  # Specify the filename with timestamp
    save_key(key, key_filename)  # Save the key to the same folder as the script
    print(f"Key generated and saved at {key_filename}.")
