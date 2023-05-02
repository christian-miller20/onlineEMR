import { useState, useEffect } from 'react';
import { PieChart } from 'react-minimal-pie-chart'
import BaseNavbar from './BaseNavbar';
import { 
  Container, 
  Row, 
  Col, 
  Card
} from "react-bootstrap";


// useLocation can be used to grab data
function ViewData(props) {
  const [query, setQuery] = useState('');
  const [result, setResult] = useState([]);
  const [data, setData] = useState([]);
  const [mode, setMode] = useState('chief_complaint');
  // const [complaint, setComplaint] = useState([])
  const [treatments, setTreatments] = useState([]);

  useEffect(() => {
    fetch('http://3.95.80.50:8005/viewdata/pie.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ 
        "mode" : mode 
      })
    })
      .then(response => response.json())
      .then(data => setData(data))
      .then(console.log(data))
      .catch(error => console.log(error));
  }, [mode]);

  useEffect(() => {
    fetch(`http://3.95.80.50:8005/viewdata/treatments.php`)
      .then(response => response.json())
      .then(treatments => setTreatments(treatments));
  }, []);

  // Use this function to get the list of chief_complaints for emergency visits
  // useEffect(() => {
  //   fetch('http://3.95.80.50:8005/viewdata/emergency.php', {
  //     method: 'POST',
  //     headers: { 'Content-Type': 'application/json' },
  //     body: JSON.stringify({ 
  //       "mode" : mode 
  //     })
  //   })
  //     .then(response => response.json())
  //     .then(complaint => setComplaint(complaint))
  //     .catch(error => console.log(error));
  // }, []);

  const handleButtonClick = (mode) => {
    setMode(mode);
  }
  
  const handleSubmit = (event) => {
    event.preventDefault();
    if (!query) {
      return;
    }
    console.log(JSON.stringify({ 
      "query" : query 
    }));
    fetch('http://3.95.80.50:8005/viewdata/query.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ 
        query : query 
      })
    })
    .then(response => response.json())
    .then(data => setResult(data))
    .catch(error => console.log(error));
  }

  const handleClear = () => {
    setQuery("");
    setResult([]);
  };
  

  return (
  <div>
    <div>
      <BaseNavbar/>
      <br></br>
    </div>
    <Container>
      <Row>
      <Card>
  <Card.Header>
    <h3>Query</h3>
  </Card.Header>
      <Card.Body className={`d-flex align-items-center justify-content-center ${result.length > 0 ? 'has-results' : ''}`}>
        <div style={{ width: "100%" }}>
          <form className="Auth-form" onSubmit={handleSubmit} style={{ width: "100%" }}>
            <h3 className="search-bar"></h3>
            <input
              type="query"
              className="form-control mt-1"
              placeholder="Enter SQL Query"
              name="query"
              id="query"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
            />
            <button type="submit" className="btn btn-primary">
              Submit
            </button>
            <button className="btn btn-link" onClick={handleClear}>
              Clear
            </button>
          </form>
          {result.length > 0 && (
            <div className="table-wrapper" style={{ clear: "both", marginTop: "1rem" }}>
              <table>
                <thead>
                  <tr>
                    {Object.keys(result[0]).map((key) => <th key={key}>{key}</th>)}
                  </tr>
                </thead>
                <tbody>
                  {result.map((row, index) => (
                    <tr key={index}>
                      {Object.values(row).map((value, index) => (
                        <td key={index}>{value}</td>
                      ))}
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </Card.Body>
    </Card>

        <Col md={6}>
          <Card style = {{height:"100%"}}>
          <Card.Header>
            <h3>Search Visits By</h3>
          </Card.Header>
            <Card.Body>
              <button className='custom-button' onClick={() => handleButtonClick('chief_complaint')}>Chief Complaint</button>
              <button className='custom-button' onClick={() => handleButtonClick('visit_type')}>Visit Type</button>
              <button className='custom-button' onClick={() => handleButtonClick('doctor_name')}>Doctor</button>
              <div>
                <PieChart
                  data={data}
                  label={({ dataEntry }) => `${dataEntry.title}: ${dataEntry.value}%`}
                  labelStyle={{
                    fontSize: '2px',
                    fontWeight: 'bold',
                    fill: '#FFFFFF',
                    padding: 20
                  }}
                  labelPosition={60}
                />
              </div>
            </Card.Body>
          </Card>
        </Col>
        <Col md={6}>
          <Card style={{height:"100%"}}>
          <Card.Header>
            <h3>Most Common Treatments this Year</h3>
          </Card.Header>
          <Card.Body className="d-flex align-items-center justify-content-center" style={{height: '100%'}}>
              <table style={{ width: '80%', height: '80%' }}>
                <thead>
                  <tr>
                    <th>Treatment</th>
                    <th>Total YTD</th>
                  </tr>
                </thead>
                <tbody>
                  {treatments.map(item => (
                    <tr key={item.TREATMENT_TYPE}>
                      <td>{item.TREATMENT_TYPE}</td>
                      <td>{item.TOTAL}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
          </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  </div>
  );
}


export default ViewData;