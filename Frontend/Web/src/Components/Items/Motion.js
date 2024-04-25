import React, { useState, useEffect } from "react";
import "../../Scss/Main.scss";
import "../../Scss/Button.scss";
import safe from "../../Images/safe.png";
import Danger from "../../Images/32.png";

const Lights = () => {
  const [isVisible, setIsVisible] = useState(false);
  const [isChecked, setIsChecked] = useState(false);

  const handleCheckboxChange = () => {
    setIsChecked(!isChecked);
    console.log("check", isChecked);
  };

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(1);
    }, 2000);

    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="tempr">
      <div className="temp">
        {isChecked == false ? (
          <img src={safe} alt="safe" className="Sun" />
        ) : null}
        {isChecked == true ? (
          <img src={Danger} alt="Danger" className="Sun" />
        ) : null}
      </div>
      {isChecked == false ? <h4></h4> : null}
      {isChecked == true ? <h4 style={{ color: "red" }}>Danger!</h4> : null}
      <input
        type="checkbox"
        role="switch"
        className="toggle"
        checked={isChecked}
        onChange={handleCheckboxChange}
      />
    </div>
  );
};

export default Lights;
