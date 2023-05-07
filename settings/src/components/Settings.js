import React, { useState } from 'react';
import BaseNavbar from './BaseNavbar';

function Settings() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(username, password);
    fetch('http://3.95.80.50:8005/settings/createuser.php', {
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
      console.log(data);
      if (data.success) {
        alert("User Created Succesfully");
        setPassword('');
        setUsername('');
      }
      else {
        alert('Unable to create user with credentials provided!');
        setPassword('');
        setUsername('');
      }
    })
    .catch((error) => {
      console.log(error);
    });

  }


  return (
    <div>
    <BaseNavbar></BaseNavbar>
    <div className="Auth-form-container">
        <form className="Auth-form" onSubmit={handleSubmit}>
          <div className="Auth-form-content">
            <h3 className="Auth-form-title">Create New User</h3>
            <div className="form-group mt-3">
              <label>Username</label>
              <input
                type="username"
                className="form-control mt-1"
                placeholder="Enter username"
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
                Create
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
}

export default Settings;