import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';

function BaseNavbar() {

    const handleLogout = (e) => {
        window.location.href = `http://3.95.80.50:8005/logout`
    };

    function handleLinkClick(path){
        window.location.href = `http://3.95.80.50:8005/${path}`
    };

    return (
        <Navbar bg="light" expand="lg">
            <Container>
                <Navbar.Brand onClick={(e) => handleLinkClick('')}>MedDB</Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                <Nav className="me-auto">
                    <Nav.Link onClick={(e) => handleLinkClick('/dashboard')}>Home</Nav.Link>
                    <Nav.Link onClick={(e) => handleLinkClick('/newpatientchart')}>Create New Patient</Nav.Link> 
                    <Nav.Link onClick={(e) => handleLinkClick('/patientchart')}>Patient Chart</Nav.Link>
                    <Nav.Link onClick={(e) => handleLinkClick('/viewdata')}>View Data</Nav.Link>
                    <Nav.Link onClick={(e) => handleLinkClick('/settings')}>Settings</Nav.Link>
                </Nav>
                <Nav className="m1-auto">
                    <button className="btn btn-primary" onClick={(e) => handleLogout(e)}>
                        Logout
                    </button>
                </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    );
}

export default BaseNavbar;