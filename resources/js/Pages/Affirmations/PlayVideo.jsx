import React, { Component, useEffect, useState } from "react";

import SecondaryButton from "../../Components/SecondaryButton";
import SoundWave from "./SoundWave";
import SlickSlider from "../../Components/SlickSlider";
import Kaleidoscope from "../../Components/Kaleidoscope";

const PlayVideo = ({ affirmation, currentStep }) => {
    const [audioUrl, setAudioUrl] = useState();
    const [playing, setPlay] = useState(false);

    const playPreview = (playing) => {
        setPlay(playing);
    };

    useEffect(() => {
        setAudioUrl(affirmation?.mixed_audio_url ?? affirmation?.audio_url);
    }, []);
    console.log(affirmation);
    return (
        <>
            <div className="min-h-[calc(75vh-304px)]">
                <div className="grid grid-cols-12 md:grid-cols-10">
                    <div className="col-start-1 md:col-start-3 col-span-12 md:col-span-6 ">
                        <h4 className="text-white mb-2 text-center">{affirmation.name}</h4>
                        <div className="my-2 relative min-h-[380px]">
                            {affirmation.effect_type == "kaleidoscope" ? (
                                <Kaleidoscope
                                    images={affirmation?.images_url}
                                    playing={playing}
                                />
                            ) : (
                                <SlickSlider affirmation={affirmation} playing={playing} />
                            )}
                        </div>
                        <SoundWave
                            url={audioUrl}
                            id={affirmation.id}
                            isWaveDisplay={true}
                            isTimeDisplay={false}
                            onPlayPreview={playPreview}
                        />
                        {/* <div className="flex items-center justify-center  mt-5 gap-3 flex-wrap">
                            <SecondaryButton className="capitalize xs:w-full xs:justify-center whitespace-nowrap">
                                Save Affirmations
                            </SecondaryButton>
                        </div> */}
                    </div>
                </div>
            </div>
        </>
    );
};

export default PlayVideo;
