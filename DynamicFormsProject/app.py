from flask import Flask, render_template, request

app = Flask(__name__)

@app.route('/')
def login_page():
    return render_template('login.html')

@app.route('/load_form/<role>', methods=['GET'])
def load_form(role):
    if role == 'student':
        return render_template('student_form.html')
    elif role == 'librarian':
        return render_template('librarian_form.html')
    elif role == 'retail':
        return render_template('retail_form.html')
    return 'Invalid role'

@app.route('/submit_form', methods=['POST'])
def submit_form():
    # Handle form submission (CRUD operations can be added here)
    form_data = request.form
    # Process form data here, e.g., save to database
    return 'Form submitted successfully!'

if __name__ == '__main__':
    app.run(debug=True)
