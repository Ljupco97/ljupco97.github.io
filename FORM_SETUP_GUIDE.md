# Contact Form Setup Guide

## ✅ Option 1: PHP Backend (Already Implemented)

### Requirements:

- Web hosting with PHP support
- PHP mail() function enabled on server

### Setup Steps:

1. **Edit `send-email.php`** - Change line 18:

   ```php
   $recipient = "your-email@example.com"; // Change to YOUR email
   ```

2. **Upload files to your web server:**

   - `index.html`
   - `send-email.php`

3. **Test the form** - Submit a test message and check your email

### Troubleshooting:

- If emails don't arrive, check your spam folder
- Contact your hosting provider to ensure PHP mail() is enabled
- Some hosts require SMTP configuration instead of mail()

---

## 🚀 Option 2: Formspree (Easiest - No Backend Required)

### Setup Steps:

1. Go to [https://formspree.io](https://formspree.io)
2. Sign up for a free account
3. Create a new form and get your form ID
4. Update your HTML form action:

```html
<form
  action="https://formspree.io/f/YOUR_FORM_ID"
  method="POST"
  class="contact-form"
>
  <input type="text" name="name" placeholder="Your Name" required />
  <input type="email" name="email" placeholder="Your Email" required />
  <textarea
    name="message"
    placeholder="Your Message"
    rows="5"
    required
  ></textarea>
  <button type="submit" class="btn">Send Message</button>
</form>
```

5. Replace `YOUR_FORM_ID` with your actual Formspree form ID
6. Done! Formspree handles everything for you

**Pros:**

- No backend code needed
- Works on any hosting (including GitHub Pages)
- Built-in spam protection
- Email notifications

---

## 📧 Option 3: EmailJS (JavaScript Only)

### Setup Steps:

1. Go to [https://www.emailjs.com](https://www.emailjs.com)
2. Sign up for free (200 emails/month)
3. Add an email service (Gmail, Outlook, etc.)
4. Create an email template
5. Get your credentials (User ID, Service ID, Template ID)

6. Add EmailJS script to your HTML (before closing `</body>`):

```html
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
<script>
  emailjs.init("YOUR_USER_ID");
</script>
```

7. Update the contact form JavaScript:

```javascript
// Contact form with EmailJS
(function () {
  const form = document.querySelector(".contact-form");
  if (!form) return;
  const status = form.querySelector(".form-status");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    status.textContent = "Sending...";
    status.style.color = "var(--muted)";

    emailjs.sendForm("YOUR_SERVICE_ID", "YOUR_TEMPLATE_ID", form).then(
      function () {
        status.textContent = "Thank you! Your message has been sent.";
        status.style.color = "#22c55e";
        form.reset();
      },
      function (error) {
        status.textContent = "Oops! Something went wrong.";
        status.style.color = "#ef4444";
        console.error("Error:", error);
      }
    );
  });
})();
```

---

## 🐍 Option 4: Python Flask Backend

If you prefer Python, here's a simple Flask backend:

### File: `app.py`

```python
from flask import Flask, request, jsonify
from flask_mail import Mail, Message
import os

app = Flask(__name__)

# Email configuration
app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 587
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USERNAME'] = 'your-email@gmail.com'  # Change this
app.config['MAIL_PASSWORD'] = 'your-app-password'      # Change this
app.config['MAIL_DEFAULT_SENDER'] = 'your-email@gmail.com'

mail = Mail(app)

@app.route('/send-email', methods=['POST'])
def send_email():
    try:
        name = request.form.get('name')
        email = request.form.get('email')
        message = request.form.get('message')

        if not name or not email or not message:
            return jsonify({'success': False, 'message': 'All fields required'}), 400

        msg = Message(
            subject=f'New Contact Form Submission from {name}',
            recipients=['your-email@gmail.com'],  # Where to receive emails
            body=f'Name: {name}\nEmail: {email}\n\nMessage:\n{message}'
        )

        mail.send(msg)
        return jsonify({'success': True, 'message': 'Message sent successfully!'})

    except Exception as e:
        return jsonify({'success': False, 'message': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
```

### Install dependencies:

```bash
pip install flask flask-mail
```

### Run:

```bash
python app.py
```

---

## 📝 Recommendation

**For beginners:** Use **Formspree** (Option 2) - it's the easiest and requires no backend setup.

**For more control:** Use **PHP** (Option 1) - already implemented, just need to update email address.

**For modern approach:** Use **EmailJS** (Option 3) - works client-side, great for static hosting.

**For Python lovers:** Use **Flask** (Option 4) - if you're comfortable with Python.

---

## 🔒 Security Tips

1. **Always validate input** on the server-side
2. **Use CAPTCHA** (like Google reCAPTCHA) to prevent spam
3. **Rate limit** form submissions
4. **Never expose** email credentials in client-side code
5. **Use HTTPS** when handling form data

---

## Need Help?

If you need help implementing any of these options, let me know which one you prefer!
