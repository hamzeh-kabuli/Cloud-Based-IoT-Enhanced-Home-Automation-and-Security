import React from "react";
import "../../Scss/Main.scss";
import "../../Scss/Button.scss";

const Temperature = () => {
  return (
    <div className="tempr" style={{ width: "21rem" }}>
      <div className="temp">
        <section id="sha_temp_body" class="col-12">
          <div class="row">
            <div className="col-12">
              <span className="sha_temp">
                <span>
                  <span className="temp-data">
                    {" "}
                    16 <sup>&deg;C</sup>{" "}
                  </span>
                  <span className="temp-info">
                    <i className="fa fa-snowflake-o"></i> Temperature
                  </span>
                </span>
              </span>
              <span className="sha_temp">
                <span>
                  <span className="temp-data">
                    {" "}
                    40 <sup>%</sup>{" "}
                  </span>
                  <span className="temp-info">
                    <i className="fa fa-snowflake-o"></i> Humidity
                  </span>
                </span>
              </span>
            </div>
          </div>
        </section>
      </div>
      <input type="checkbox" role="switch" className="toggle" />
    </div>
  );
};

export default Temperature;
