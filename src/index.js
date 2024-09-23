const express = require('express');
const Joi = require('joi');
const app = express();
const cors = require('cors');
// Define a schema for user data
const userSchema = Joi.object({
    name: Joi.string().required(),
    email: Joi.string().email().required(),
    password: Joi.string().min(8).required(),})
    // Validate user creation requests
app.post('/users', celebrate({
    body: userSchema,
  }), (req, res) => {
    // If validation passes, create the user
    // ...
  });

app.get('/', (req, res) => {
  res.send('Hello, world!');
});

app.listen(3000, () => {
  console.log('Server listening on port 3000');   

});

// Configure CORS
app.use(cors());

// ... other server setup

