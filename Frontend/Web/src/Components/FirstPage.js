import React, { useState, useEffect } from "react";
import "../Scss/Main.scss";
import "../Scss/Button.scss";
import Wait from "../Images/waiting2.gif";
import Temperature from "./Items/Temperature";
import Lights from "./Items/Lights";
import Motion from "./Items/Motion";
import Header from "./Items/Header";


const FirstPage = () => {
  const [isVisible, setIsVisible] = useState(false);
  const [isChecked, setIsChecked] = useState(false);


  const handleCheckboxChange = () => {
    setIsChecked(!isChecked);
    console.log('check', isChecked)
  };


 
  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(1);
    }, 2000); 

    return () => clearTimeout(timer); 
  }, []); 

  return (
    <div className="FirstPage">
      
      {isVisible == 1 ?null:<div className="waiting">
         <img src={Wait} alt="" />
       </div>}
       
    
      <div className="shadow">

        <Header/>
        <Temperature/>
        <Lights/>
        <Motion/>

        


        
      </div>
    </div>
  );
};

export default FirstPage;
