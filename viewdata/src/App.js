import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import ViewData from './components/ViewData';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='viewdata'>
        <Routes>
          <Route exact path="/" element={<ViewData />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
