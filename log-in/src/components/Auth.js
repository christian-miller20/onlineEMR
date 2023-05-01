import React, { useState } from "react"
import "./Auth.css"

function Auth(props) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

  
    const handleSubmit = (e) => {
      e.preventDefault();
      console.log(username, password);
      fetch('http://3.95.80.50:8005/log-in/authenticate.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          username: username,
          password: password
        })
      })
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        console.log(data)
        if (data.success) {
          redirect(data.username);
        }
        else {
          setErrorMessage('Invalid username or password');
        }
      })
      .catch((error) => {
        console.log(error);
      });
    }


    return (
      <div className="Auth-form-container">
        <form className="Auth-form" onSubmit={handleSubmit}>
          <div className="Auth-form-content">
            <h3 className="Auth-form-title">Sign In</h3>
            <div className="form-group mt-3">
              <label>Email address</label>
              <input
                type="email"
                className="form-control mt-1"
                placeholder="Enter email"
                name="username" 
                id="username" 
                value={username} 
                onChange={(e) => setUsername(e.target.value)}
              />
            </div>
            <div className="form-group mt-3">
              <label>Password</label>
              <input
                type="password"
                className="form-control mt-1"
                placeholder="Enter password"
                name='password' 
                id='password' 
                value={password} 
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div className="d-grid gap-2 mt-3">
              <button type="submit" className="btn btn-primary">
                Submit
              </button>
            </div>
          </div>
          {errorMessage && <div className="forgot-password text-center mt-2">{errorMessage}</div>}
        </form>
      </div>
    )
  }

// use this function to pass state
function redirect(username) {
    const searchParams = new URLSearchParams();
    searchParams.set('username', username);
    
    const url = new URL('http://3.95.80.50:8005/dashboard/', window.location.origin);
    url.search = searchParams.toString();
    
    window.location.href = url.toString();
}
  

export default Auth;