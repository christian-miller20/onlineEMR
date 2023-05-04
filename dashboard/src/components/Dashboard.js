import BaseNavbar from './BaseNavbar';

function Dashboard() {

  return (
    <div>
      <BaseNavbar></BaseNavbar>
      <div style={{backgroundColor: 'rgb:29,29,29', height: '100vh', display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center'}}>
        <div style={{justifyContent: 'left'}}>
          <h1 style={{color: 'white', fontWeight: 'bold'}}>Welcome to MedDb EMR System</h1>
          <br></br>
          <ul>
            <li><h5 style={{color: 'white'}}>Add New Patients to Your Practice</h5></li>
            <br></br>
            <li><h5 style={{color: 'white'}}>Understand Existing Patient Charts</h5></li>
            <br></br>
            <li><h5 style={{color: 'white'}}>Explore Aggregate Patient Data in a Single View</h5></li>
          </ul>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;