import React, { useState, useEffect } from "react";
import "../../Scss/Main.scss";
import "../../Scss/Button.scss";
import Sun from "../../Images/sun.png";
import Night from "../../Images/night.png";

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
          <img src={Sun} alt="Sun" className="Sun" />
        ) : null}
        {isChecked == true ? (
          <img src={Night} alt="Night" className="Sun" />
        ) : null}
      </div>
      {isChecked == false ? <h4>Day</h4> : null}
      {isChecked == true ? <h4>Night</h4> : null}
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
