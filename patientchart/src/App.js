import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import PatientChart from './components/PatientChart';
import "bootstrap/dist/css/bootstrap.min.css"
import './App.css';

function App() {
  return (
    <div className="App">
      <BrowserRouter basename='patientchart'>
        <Routes>
          <Route exact path="/" element={<PatientChart />} />
        </Routes>
      </BrowserRouter>
    </div>);
}

export default App;
