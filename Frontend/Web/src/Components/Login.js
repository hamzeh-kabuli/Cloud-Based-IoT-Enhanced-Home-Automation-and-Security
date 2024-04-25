import React, { useState } from "react";
import "../Scss/Main.scss";
import Logo from "../Images/Londonmet2.png";
import { useNavigate } from "react-router-dom";

const Login = () => {
  const [Login, setLogin] = useState(0);
  const [Username, setUsername] = useState(null);
  const [Password, setPassword] = useState(null);

  const navigate = useNavigate();

  function LoginSet(pass, user) {
    if (pass == "wiki" && user == "friend") {
      setLogin(1);
      navigate("/Dashboard");
      console.log("state true");
    } else {
      setLogin(3);
      console.log("state false");
    }
  }

  return (
    <div className="Login">
      <div className="shadow">
        <img src={Logo} alt="Logo" />
        <div className="box_log">
          <div className="item_input">
            <h3>Username</h3>
            <input
              type="text"
              value={Username}
              onChange={(e) => setUsername(e.target.value)}
            />
          </div>
          <div className="item_input">
            <h3>Password</h3>
            <input
              type="password"
              value={Password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </div>
          {Login == 3 ? (
            <h6>*Your Username or Password is not correct</h6>
          ) : null}

          <button
            className="InfoProData"
            onClick={(e) => {
              LoginSet(Password, Username);
            }}
          >
            Login
          </button>
        </div>
      </div>
    </div>
  );
};

export default Login;
