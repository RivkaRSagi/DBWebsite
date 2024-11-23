const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;


app.use(bodyParser.urlencoded({ extended: true }));

// Set the view engine to render HTML templates
app.set('view engine', 'ejs');  
app.set('views', path.join(__dirname, 'views'));

// Serve static files (e.g., CSS, JS)
app.use(express.static(path.join(__dirname, 'public')));

// Route for the login page
app.get('/', (req, res) => {
    res.render('login');
});

// Route to load forms based on role
app.get('/load_form/:role', (req, res) => {
    const role = req.params.role;
    
    if (role === 'student') {
        res.render('student_form');
    } else if (role === 'librarian') {
        res.render('librarian_form');
    } else if (role === 'retail') {
        res.render('retail_form');
    } else {
        res.send('Invalid role');
    }
});

app.post('/handle_login', (req, res) => {
    const role = req.body.role;

    // Redirect to the appropriate form based on the role
    if (role === 'student') {
        res.redirect('/load_form/student');
    } else if (role === 'librarian') {
        res.redirect('/load_form/librarian');
    } else if (role === 'retail') {
        res.redirect('/load_form/retail');
    } else {
        res.send('Invalid role');
    }
});

// Route to handle form submission
app.post('/submit_form', (req, res) => {
    const formData = req.body;
    console.log(formData); // You can handle form data here (e.g., save to a database)
    res.send('Form submitted successfully!');
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
