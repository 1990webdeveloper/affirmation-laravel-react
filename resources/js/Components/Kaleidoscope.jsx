import React, { useState, useEffect } from "react";

import { KaleidoscopeEffect, Rotate } from "./KaleidoscopeEffect";

// > Render several Kaleidoscope components on top of each other
// > Move the background image of the Kaleidoscope components based on mouse movement

const Kaleidoscope = (props) => {
    const [eff, setEff] = useState({
        x: 0,
        y: 0,
    });
    let onMouseOver = (e) => {
        console.log(e.clientX, e.clientY);
        setEff({
            x: e.clientX,
            y: e.clientY,
        });
    };

    useEffect(() => {
        let xData = parseInt(0);
        let yData = parseInt(0);
        const interval = setInterval(() => {
            setEff({
                x: xData,
                y: yData,
            });
            xData = xData + parseInt(5);
            yData = yData + parseInt(5);
        }, 100);

        // return () => clearInterval(interval); // This represents the unmount function, in which you need to clear your interval to prevent memory leaks.
    }, []);

    // let touchMove = (e) => {
    //     setEff({
    //         x: e.touches[0].clientX / 2,
    //         y: e.touches[0].clientY / 2,
    //     });
    // };
    return (
        <div
            // onMouseMove={(e) => onMouseOver(e)}
            // onTouchMove={(e) => touchMove(e)}
            style={{ maxHeight: "100px", maxWidth: "100px" }}
        >
            {props.images?.map((image, index) => (
                <KaleidoscopeEffect
                    key={index}
                    slices={12}
                    x={eff.x}
                    y={eff.y}
                    r={65}
                    img={image}
                    playing={props.playing}
                />
            ))}
        </div>
    );
};

export default Kaleidoscope;
