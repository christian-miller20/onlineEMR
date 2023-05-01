import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Auth from './components/Auth';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='log-in'>
        <Routes>
          <Route exact path="/" element={<Auth />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
