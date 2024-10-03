import React, { useEffect, useRef, useState } from "react";

import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";

const SlickSlider = ({ affirmation, playing }) => {
    const images = affirmation?.images_url;
    const [settings, setSetting] = useState({
        autoplay: false,
        draggable: true,
        arrows: false,
        dots: false,
        fade: true,
        speed: 1000,
        infinite: true,
        cssEase: "cubic-bezier(0.7, 0, 0.3, 1)",
        touchThreshold: 100,
        autoplaySpeed: 2000,
        pauseOnHover: false,
    });

    const slider = useRef(null);

    useEffect(() => {
        if (playing) {
            slider.current.slickPlay();
        } else {
            slider.current.slickPause();
        }
    }, [playing]);

    return (
        <Slider {...settings} ref={slider}>
            {images?.map((item, index) => {
                return (
                    <React.Fragment key={index}>
                        <img
                            className="block h-96 w-full rounded-md object-cover object-center"
                            src={item}
                            alt="img"
                        />
                        {/* <div className="text-white">
                            {affirmation.recorded_transcription}
                        </div> */}
                    </React.Fragment>
                );
            })}
        </Slider>
    );
};

export default SlickSlider;
