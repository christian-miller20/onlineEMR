import { useState } from 'react';
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

  const handleSubmit = (event) => {
    event.preventDefault();
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
  

  return (
  <div>
    <div>
      <BaseNavbar/>
    </div>
    <Container>
      <Row className="justify-content-center my-4">
        <Col md={6}>
          <Card style = {{height:"100%"}}>
            <Card.Body>
              <Card.Title>Search For Patient by Name or ID</Card.Title>



            </Card.Body>
          </Card>
        </Col>
        <Col md={6}>
          <Card style={{height:"100%"}}>
            <Card.Body className="d-flex align-items-center justify-content-center" style={{height: '100%'}}>
              


            </Card.Body>
          </Card>
        </Col>
      </Row>
      <Row className="justify-content-center my-4">
        <div>
          <div className="Auth-form-container">
            <form className="Auth-form" onSubmit={handleSubmit}>
              <div className="Auth-form-content">
                <h3 className="Auth-form-title">Query</h3>
                <div className="form-group mt-3">
                  <input
                    type="query"
                    className="form-control mt-1"
                    placeholder="Enter SQL Query"
                    name="query" 
                    id="query" 
                    value={query} 
                    onChange={(e) => setQuery(e.target.value)}
                  />
                  <button type="submit" className="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
            <div className="table-wrapper">
              <table>
                <thead>
                  <tr>
                    {result.length > 0 &&
                      Object.keys(result[0]).map(key => (
                        <th key={key}>{key}</th>
                      ))
                    }
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
          </div>
      </Row>
    </Container>
  </div>
  );
}


export default ViewData;