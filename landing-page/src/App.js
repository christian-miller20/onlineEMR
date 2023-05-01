import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import WelcomePage from './components/WelcomePage';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='landing-page'>
        <Routes>
          <Route exact path="/" element={<WelcomePage />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
