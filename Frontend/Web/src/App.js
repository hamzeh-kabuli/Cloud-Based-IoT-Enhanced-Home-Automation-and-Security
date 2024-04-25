import "../src/Scss/Main.scss";
import Login from "./Components/Login";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import FirstPage from "./Components/FirstPage";

function App() {
  return (
    <div className="App">
      <div className="container">
        <Router>
          <Routes>
            <Route exact path="/" element={<Login />} />
            <Route exact path="/Dashboard" element={<FirstPage />} />
          </Routes>
        </Router>
      </div>
    </div>
  );
}

export default App;
