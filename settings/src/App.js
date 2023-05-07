import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Settings from './components/Settings';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='settings'>
        <Routes>
          <Route exact path="/" element={<Settings />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
