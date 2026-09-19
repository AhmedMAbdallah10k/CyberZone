import tkinter as tk
from PIL import Image, ImageTk
import base64

class EscapeRoomApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Cybersecurity Escape Room")
        self.root.geometry('600x400')  # Set the window size
        self.root.resizable(False, False)  # Enable resizing to see dynamic images

        # Window icon
        icon_image = Image.open("./skullLogo.png")
        self.icon = ImageTk.PhotoImage(icon_image)
        self.root.iconphoto(True, self.icon)

        # Background image paths
        self.bg_image_path = "./images.jpeg"
        self.welcome_bg_image_path = "./skullLogo2.png"

        # Frame initialization
        self.frames = {}
        self.entries = {}  # To keep track of entry widgets for clearing
        self.feedback_labels = {}  # To display feedback directly in the challenge frames
        self.setup_frames()

        # Start by showing the intro frame
        self.show_frame("intro")

    def setup_frames(self):
        self.frames["intro"] = self.create_intro_frame()
        self.frames["encryption"] = self.create_encryption_frame()
        self.frames["steganography"] = self.create_steganography_frame()
        self.frames["network_security"] = self.create_network_security_frame()
        self.frames["congratulations"] = self.create_congratulations_frame()

    def create_frame_with_background(self, parent, image_path):
        frame = tk.Canvas(parent, width=600, height=400)
        # Open and resize the image dynamically
        image = Image.open(image_path)
        resized_image = image.resize((600, 400), Image.Resampling.LANCZOS)
        background_image = ImageTk.PhotoImage(resized_image)
        frame.background_image = background_image  # Keep a reference!
        frame.create_image(0, 0, image=background_image, anchor="nw")
        frame.pack(fill="both", expand=True)
        return frame

    def create_intro_frame(self):
        frame = self.create_frame_with_background(self.root, self.welcome_bg_image_path)
        label = tk.Label(frame, text="Welcome to the Cybersecurity Escape Room!\n"
                                     "You will face several challenges based on different aspects of cybersecurity.\n"
                                     "Solve each one to move to the next room. Good luck!",
                         fg='red', bg='black', font=('Helvetica', 14, 'bold'), wraplength=580)
        label.pack(padx=20, pady=(80, 20))
        button = tk.Button(frame, text="Start Challenge", command=lambda: self.show_frame("encryption"),
                           bg='red', fg='black', font=('Helvetica', 12, 'bold'))
        button.pack(pady=(0, 80))
        return frame

    def create_encryption_frame(self):
        frame = self.create_frame_with_background(self.root, self.bg_image_path)
        encoded_message = base64.b64encode(b"Welcome to the second room").decode('utf-8')
        label = tk.Label(frame, text="Encryption Challenge:\n"
                                     "The following message is encoded in Base64 format. Can you decode it?\n" + encoded_message,
                         fg='red', bg='black', font=('Helvetica', 12), wraplength=580)
        label.pack(padx=20, pady=20)
        entry = tk.Entry(frame, fg='red', bg='white', font=('Helvetica', 12), insertbackground='black')
        entry.pack(padx=20, ipady=5)
        feedback_label = tk.Label(frame, text="", fg='red', bg='black', font=('Helvetica', 12))
        feedback_label.pack(pady=5)
        button = tk.Button(frame, text="Submit", command=lambda: self.check_encryption(entry, feedback_label),
                           bg='red', fg='black', font=('Helvetica', 12))
        button.pack(pady=10)
        self.entries["encryption"] = entry
        self.feedback_labels["encryption"] = feedback_label
        return frame

    def check_encryption(self, entry, feedback_label):
        if entry.get() == "Welcome to the second room":
            self.show_frame("steganography")
        else:
            feedback_label.config(text="Incorrect, try again!")

    def create_steganography_frame(self):
        frame = self.create_frame_with_background(self.root, self.bg_image_path)
        text = ("Steganography Challenge:\n"
                "Hidden within the following text is a secret message formed by taking the first letter of every word.\n"
                "Text: 'Every new day brings infinite possibilities. Acquire knowledge and develop understanding. Learn continuously and grow exponentially.'")
        label = tk.Label(frame, text=text, fg='red', bg='black', font=('Helvetica', 12), wraplength=580)
        label.pack(padx=20, pady=20)
        entry = tk.Entry(frame, fg='red', bg='white', font=('Helvetica', 12), insertbackground='black')
        entry.pack(padx=20, ipady=5)
        feedback_label = tk.Label(frame, text="", fg='red', bg='black', font=('Helvetica', 12))
        feedback_label.pack(pady=5)
        button = tk.Button(frame, text="Submit", command=lambda: self.check_steganography(entry, feedback_label),
                           bg='red', fg='black', font=('Helvetica', 12))
        button.pack(pady=10)
        self.entries["steganography"] = entry
        self.feedback_labels["steganography"] = feedback_label
        return frame

    def check_steganography(self, entry, feedback_label):
        if entry.get().strip().upper() == "ENDANGER":
            self.show_frame("network_security")
        else:
            feedback_label.config(text="Incorrect, try again!")

    def create_network_security_frame(self):
        frame = self.create_frame_with_background(self.root, self.bg_image_path)
        text = ("Network Security Challenge:\n"
                "Answer this question: What is the main purpose of using a firewall?\n"
                "a) Monitoring network traffic\nb) Blocking unauthorized access\nc) Speeding up the network")
        label = tk.Label(frame, text=text, fg='red', bg='black', font=('Helvetica', 12), wraplength=580)
        label.pack(padx=20, pady=20)
        entry = tk.Entry(frame, fg='red', bg='white', font=('Helvetica', 12), insertbackground='black')
        entry.pack(padx=20, ipady=5)
        feedback_label = tk.Label(frame, text="", fg='red', bg='black', font=('Helvetica', 12))
        feedback_label.pack(pady=5)
        button = tk.Button(frame, text="Submit", command=lambda: self.check_network_security(entry, feedback_label),
                           bg='red', fg='black', font=('Helvetica', 12))
        button.pack(pady=10)
        self.entries["network_security"] = entry
        self.feedback_labels["network_security"] = feedback_label
        return frame

    def check_network_security(self, entry, feedback_label):
        if entry.get().lower() == 'b':
            self.show_frame("congratulations")  # Show congratulations frame on correct answer
        else:
            feedback_label.config(text="Incorrect, try again!")

    def create_congratulations_frame(self):
        frame = self.create_frame_with_background(self.root, self.bg_image_path)
        label = tk.Label(frame, text="Congratulations!\nYou have completed all the challenges successfully!",
                         fg='green', bg='black', font=('Helvetica', 16, 'bold'), wraplength=580)
        label.pack(padx=20, pady=(80, 20))
        button = tk.Button(frame, text="Back to Start", command=lambda: self.reset_game(),
                           bg='red', fg='black', font=('Helvetica', 12, 'bold'))
        button.pack(pady=(0, 80))
        return frame

    def reset_game(self):
        # Clear all entry fields and feedback labels
        for key in self.entries:
            self.entries[key].delete(0, tk.END)
            self.feedback_labels[key].config(text="")
        self.show_frame("intro")  # Go back to the intro frame

    def show_frame(self, frame_key):
        frame = self.frames[frame_key]
        frame.pack(fill='both', expand=True)
        for f in self.frames.values():
            if f is not frame:
                f.pack_forget()

def main():
    root = tk.Tk()
    app = EscapeRoomApp(root)
    root.mainloop()

if __name__ == "__main__":
    main()
