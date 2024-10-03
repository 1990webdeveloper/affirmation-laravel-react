import React, { useCallback, useEffect, useRef, useState } from "react";
import { WaveSurfer, WaveForm } from "wavesurfer-react";
import soundLoader from "../../../images/loading-ani.gif";
import { BsFillPlayCircleFill, BsPauseCircleFill } from "react-icons/bs";

const SoundWave = ({
    url,
    id,
    isWaveDisplay,
    isTimeDisplay,
    onPlayPreview,
}) => {
    const [playing, setPlay] = useState(false);
    const [valumeVal, setValumeVal] = useState(10);
    const wavesurferRef = useRef();
    const [duration, setDuration] = useState("00:00");

    const handleWSMount = (waveSurfer) => {
        wavesurferRef.current = waveSurfer;
        setPlay(false);
        if (wavesurferRef.current) {
            wavesurferRef.current.load(url);
            wavesurferRef.current.on("ready", () => {
                console.log(
                    convertSecondsToTime(wavesurferRef.current.getDuration()),
                    "WaveSurfer is ready."
                );
            });

            wavesurferRef.current.on("loading", (data) => {
                console.log("loading --> ", data);
            });

            if (window) {
                window.surferidze = wavesurferRef.current;
            }
        }
    };

    const convertSecondsToTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const formattedMinutes = minutes.toString().padStart(2, "0");
        const formattedSeconds = (seconds % 60).toFixed(0).padStart(2, "0");
        setDuration(`${formattedMinutes}:${formattedSeconds}`);
        return `${formattedMinutes}:${formattedSeconds}`;
    };

    const handlePlayPause = () => {
        if (!url) return;
        setPlay(!playing);
        wavesurferRef.current.playPause();
        onPlayPreview(!playing);
    };

    useEffect(() => {
        if (wavesurferRef?.current) {
            wavesurferRef.current.on("finish", () => {
                console.log("Track Finished");
                setPlay(false);
            });
        }
        if (url) {
            wavesurferRef.current.load(url);
        }
        return () => {
            if (wavesurferRef?.current) {
                wavesurferRef.current.on("finish", () => {
                    console.log("Track Finished");
                    setPlay(false);
                });
            }
        };
    }, [url]);

    const increaseVolume = () => {
        if (wavesurferRef.current) {
            const currentVolume = wavesurferRef.current.getVolume();
            console.log("currentVolume: ", currentVolume);
            const newVolume = currentVolume + valumeVal;
            wavesurferRef.current.setVolume(newVolume > 100 ? 100 : newVolume); // Increase volume by 0.1
        }
    };

    const decreaseVolume = () => {
        if (wavesurferRef.current) {
            const currentVolume = wavesurferRef.current.getVolume();
            console.log("currentVolume: ", currentVolume);
            const newVolume = currentVolume - valumeVal;
            wavesurferRef.current.setVolume(newVolume < 0 ? 0 : newVolume); // Decrease volume by 0.1
        }
    };

    // const handleValume = (e) => {
    //     setValumeVal(e);
    //     if (wavesurferRef.current) {
    //         const currentVolume = wavesurferRef.current.getVolume();
    //         console.log("currentVolume: ", currentVolume);
    //         const newVolume = currentVolume - valumeVal;
    //         wavesurferRef.current.setVolume(e); // Decrease volume by 0.1
    //     }
    // };

    return (
        <div className="music-wave-Warpper text-white">
            <div
                className={
                    !isWaveDisplay
                        ? "flex items-center justify-center mt-4 text-2xl text-white"
                        : " mt-4 text-2xl text-white"
                }
            >
                {url ? (
                    <div className="music-outer flex" key={`musicplayer-${id}`}>
                        <button onClick={handlePlayPause} className="w-[50px]">
                            {!playing ? (
                                <BsFillPlayCircleFill className="text-4xl text-white cursor-pointer me-3" />
                            ) : (
                                <BsPauseCircleFill className="text-4xl text-white cursor-pointer me-3" />
                            )}
                        </button>
                        {isTimeDisplay && <div>{duration}</div>}
                        <div
                            className={
                                isWaveDisplay ? "w-[calc(100%-50px)]" : "hidden"
                            }
                        >
                            <WaveSurfer onMount={handleWSMount}>
                                <WaveForm
                                    height={40}
                                    progressColor={"#EAAB32"}
                                    waveColor={"#a69f9f"}
                                    barWidth={2}
                                    barRadius={3}
                                    barGap={2}
                                    cursorWidth={0}
                                    id={`waveform-${id}`}
                                ></WaveForm>
                                <div id="timeline" />
                            </WaveSurfer>
                        </div>
                    </div>
                ) : (
                    <div className="flex items-center justify-center w-100">
                        <img
                            src={soundLoader}
                            alt=""
                            className="h-[60px] w-[300px]"
                        />
                    </div>
                )}
            </div>
            {/* <div className="flex items-center justify-center mt-4 text-2xl text-white">
                <input
                    value={valumeVal}
                    onChange={(e) => handleValume(e.target.value)}
                    type="range"
                    min={0}
                    max={100}
                    className="cursor-move"
                />
            </div> */}
        </div>
    );
};

export default React.memo(SoundWave);
