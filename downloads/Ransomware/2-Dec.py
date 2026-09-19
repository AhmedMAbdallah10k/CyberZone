from Crypto.Cipher import AES
from Crypto.Util.Padding import unpad
import os
import sys

def decrypt_data(encrypted_data, key):
    iv = encrypted_data[:AES.block_size]
    cipher = AES.new(key, AES.MODE_CBC, iv)
    return unpad(cipher.decrypt(encrypted_data[AES.block_size:]), AES.block_size)

def decrypt_file_inplace(encrypted_file_path, key):
    try:
        with open(encrypted_file_path, 'rb') as f:
            encrypted_data = f.read()
        decrypted_data = decrypt_data(encrypted_data, key)
        original_file_path = encrypted_file_path[:-4]  # Remove the .enc extension
        with open(original_file_path, 'wb') as f:
            f.write(decrypted_data)
        os.remove(encrypted_file_path)  # Optionally remove the encrypted file
    except Exception as e:
        print(f"Failed to decrypt: {encrypted_file_path}. Error: {str(e)}")

def traverse_and_decrypt(start_path, key):
    for dirpath, dirnames, filenames in os.walk(start_path):
        for filename in filenames:
            if filename.endswith('.enc'):
                encrypted_file_path = os.path.join(dirpath, filename)
                decrypt_file_inplace(encrypted_file_path, key)

if __name__ == "__main__":
    key = bytes.fromhex('put the key kere')  # 32-byte AES key
    #desktop_path = os.path.join(os.environ['USERPROFILE'], 'Desktop')  # Path to Desktop
    desktop_path = r"C:\Users\dell\Desktop\Ransomwaree\Test File"  # Path to encrypted files
    traverse_and_decrypt(desktop_path, key)
    print("Decryption completed successfully.")
