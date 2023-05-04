import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import NewPatientChart from './components/newPatientChart';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='newpatientchart'>
        <Routes>
          <Route exact path="/" element={<NewPatientChart />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
