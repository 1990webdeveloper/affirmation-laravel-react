import React, { Component, useEffect, useState } from "react";

import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Selectbox from "../../Components/Selectbox";
import SecondaryButton from "../../Components/SecondaryButton";
import { BsChevronRight } from "react-icons/bs";
import { useForm } from "@inertiajs/react";
import SoundWave from "./SoundWave";
import Crunker from "crunker";
import { AiOutlineSound } from "react-icons/ai";

let crunker = new Crunker();

const SoundMixing = ({
    currentAffirmation,
    currentStep,
    affirmationData,
    binauralBeats,
    backgroundAudio,
    handleNextStep,
}) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        affirmation_id: "",
        binaural_beat_id: "",
        background_audio_id: "",
        mix_audio: "",
        mix_audio_file: "",
        step: currentStep,
    });

    const [affirmation, setAffirmation] = useState();
    const [beat, setBeat] = useState();
    const [bgAudio, setBgAudio] = useState();

    const [audioUrl, setAudioUrl] = useState();
    const [sounds, setSounds] = useState([]);
    const [mergedSound, setMergedSound] = useState();

    const [affirmationVolume, setAffirmationVolume] = useState();
    const [beatVolume, setBeatVolume] = useState();
    const [bgSoundVolume, setBgSoundVolume] = useState();

    const nextStep = (e) => {
        e.preventDefault();
        post(route("affirmation.store"), {
            onSuccess: () => {
                handleNextStep();
            },
            onError: (data) => {
                console.log(data);
            },
        });
    };

    const handleChangeAffirmation = (e) => {
        let affirmationId = e.target.value;
        if (affirmationId) {
            let activeAffirmation = affirmationData.find(
                (affirmation) => affirmation.id === parseInt(affirmationId)
            );
            setData({
                ...data,
                affirmation_id: affirmationId,
                step: activeAffirmation?.step + 1,
            });
            setAffirmation(activeAffirmation);
            setAudioUrl(activeAffirmation?.audio_url);
        }
    };

    const handleChangeBeats = (e) => {
        let beatId = e.target.value;
        setData("binaural_beat_id", beatId);
        let acitiveBeat = binauralBeats.find(
            (beat) => beat.id === parseInt(beatId)
        );
        setBeat(acitiveBeat);
        if (acitiveBeat) {
            setSounds([...sounds, { url: acitiveBeat?.beat_url }]);
        } else {
            if (acitiveBeat) {
                setSounds([
                    ...sounds.filter((item) => item.url !== beat?.beat_url),
                ]);
            } else if (bgAudio) {
                setSounds([]);
                setSounds([
                    { url: affirmation?.audio_url },
                    { url: bgAudio?.bg_audio_url },
                ]);
            } else {
                setSounds([{ url: affirmation?.audio_url }]);
            }
        }
    };

    const handleChangeBgAudio = (e) => {
        let bgAudioId = e.target.value;
        setData("background_audio_id", bgAudioId);
        let acitiveBgAudio = backgroundAudio.find(
            (bgAudio) => bgAudio.id === parseInt(bgAudioId)
        );
        setBgAudio(acitiveBgAudio);
        if (acitiveBgAudio) {
            setSounds([...sounds, { url: acitiveBgAudio?.bg_audio_url }]);
        } else {
            if (acitiveBgAudio) {
                setSounds([
                    ...sounds.filter(
                        (item) => item.url !== bgAudio?.bg_audio_url
                    ),
                ]);
            } else if (beat) {
                setSounds([]);
                setSounds([
                    { url: affirmation?.audio_url },
                    { url: beat?.beat_url },
                ]);
            } else {
                setSounds([{ url: affirmation?.audio_url }]);
            }
        }
    };

    useEffect(() => {
        console.log("affirmation", affirmation);
        if (!currentAffirmation && affirmationData.length > 0) {
            setAffirmation(affirmationData[0]);
            setAudioUrl(
                affirmationData[0]?.mixed_audio_url ??
                    affirmationData[0]?.audio_url
            );
            setSounds([
                {
                    url:
                        affirmationData[0]?.mixed_audio_url ??
                        affirmationData[0]?.audio_url,
                },
            ]);
            setData({
                ...data,
                affirmation_id: affirmationData[0]?.id,
                binaural_beat_id: affirmationData[0]?.binaural_beat_id ?? "",
                background_audio_id:
                    affirmationData[0]?.background_audio_id ?? "",
            });

            let acitiveBeat = binauralBeats.find(
                (beat) =>
                    beat.id === parseInt(affirmationData[0]?.binaural_beat_id)
            );
            let acitiveBgAudio = backgroundAudio.find(
                (bgAudio) =>
                    bgAudio.id ===
                    parseInt(affirmationData[0]?.background_audio_id)
            );
            setBeat(acitiveBeat);
            setBgAudio(acitiveBgAudio);
        } else if (currentAffirmation) {
            setAffirmation(currentAffirmation);
            setAudioUrl(
                currentAffirmation?.mixed_audio_url ??
                    currentAffirmation?.audio_url
            );
            setSounds([
                {
                    url:
                        currentAffirmation?.mixed_audio_url ??
                        currentAffirmation?.audio_url,
                },
            ]);
            setData({
                ...data,
                affirmation_id: currentAffirmation?.id,
                binaural_beat_id: currentAffirmation?.binaural_beat_id ?? "",
                background_audio_id:
                    currentAffirmation?.background_audio_id ?? "",
            });

            let acitiveBeat = binauralBeats.find(
                (beat) =>
                    beat.id === parseInt(currentAffirmation?.binaural_beat_id)
            );
            let acitiveBgAudio = backgroundAudio.find(
                (bgAudio) =>
                    bgAudio.id ===
                    parseInt(currentAffirmation?.background_audio_id)
            );
            setBeat(acitiveBeat);
            setBgAudio(acitiveBgAudio);
        }
    }, []);

    useEffect(() => {
        setAudioUrl("");
        if (sounds.length > 0) {
            crunker
                .fetchAudio(...sounds.map((item) => item?.url))
                .then((buffers) => {
                    return crunker.mergeAudio(buffers);
                })
                .then((merged) => {
                    return crunker.export(merged, "audio/mp3");
                })
                .then((output) => {
                    setAudioUrl(output.url);
                    const fileObj = new File([output.blob], "sound.mp3", {
                        type: output.blob.type,
                    });
                    setData({
                        ...data,
                        mix_audio: output.url,
                        mix_audio_file: fileObj,
                    });
                })
                .catch((error) => {
                    console.log("Error in cuncker: ", error);
                });
        }
    }, [sounds]);

    console.log("sounds", sounds);

    return (
        <>
            <div className="grid grid-cols-12 md:grid-cols-8">
                <div className="col-start-1 md:col-start-3 col-span-12 md:col-span-4 ">
                    <div className="mt-5">
                        <InputLabel
                            htmlFor="email"
                            value="Affirmation Name"
                            className="text-primary"
                        />
                        <Selectbox
                            name="affirmation"
                            className="minimal w-full cursor-pointer"
                            value={affirmation?.id}
                            onChange={handleChangeAffirmation}
                        >
                            <option value="">Select Affirmation</option>
                            {affirmationData.map((affirmation, index) => (
                                <option key={index} value={affirmation.id}>
                                    {affirmation.name}
                                </option>
                            ))}
                        </Selectbox>
                        <InputError
                            className="mt-2"
                            message={errors.affirmation_id}
                        />
                    </div>

                    <div className="mt-10">
                        <InputLabel
                            htmlFor="email"
                            value="Select the Type of Binaural Beats to Use"
                            className="text-primary"
                        />
                        <Selectbox
                            name="binaural_beats"
                            className="minimal w-full cursor-pointer"
                            onChange={handleChangeBeats}
                            value={data?.binaural_beat_id}
                        >
                            <option value="">Select Binaural Beats</option>
                            {binauralBeats.map((beats, index) => (
                                <option key={index} value={beats.id}>
                                    {beats.name}
                                </option>
                            ))}
                        </Selectbox>
                        {/* <div className="grid grid-cols-12 mt-3">
                            <div className="col-span-12 md:col-span-6 flex gap-1 text-3xl [&>*]:mb-6 md:[&>*]:mb-0">
                                <AiOutlineSound className="text-white me-2" />
                                <input
                                    className="w-full mt-0 rounded-lg cursor-pointer "
                                    type="range"
                                    min="0"
                                    max="100"
                                    onChange={(e) =>
                                        setBeatVolume(e.target.value)
                                    }
                                />
                                <div className="ms-2 text-white text-sm text-center bg-dark rounded-full w-20 pt-1">
                                    {beatVolume}%
                                </div>
                            </div>
                        </div> */}
                    </div>

                    <div className="mt-10">
                        <InputLabel
                            htmlFor="email"
                            value="Add In Other Background Sounds:"
                            className="text-primary"
                        />
                        <Selectbox
                            name="affirmation_category"
                            className="minimal w-full cursor-pointer"
                            onChange={handleChangeBgAudio}
                            value={data?.background_audio_id}
                        >
                            <option value="">Select Background Sound</option>
                            {backgroundAudio.map((bSound, index) => (
                                <option key={index} value={bSound.id}>
                                    {bSound.name}
                                </option>
                            ))}
                        </Selectbox>
                        {/* <div className="grid grid-cols-12 mt-3">
                            <div className="col-span-12 md:col-span-6 flex gap-1 text-3xl [&>*]:mb-6 md:[&>*]:mb-0">
                                <AiOutlineSound className="text-white me-2" />
                                <input
                                    className="w-full mt-0 rounded-lg cursor-pointer "
                                    type="range"
                                    min="0"
                                    max="1"
                                    step=".05"
                                />
                                <div className="ms-2 text-white text-sm text-center bg-dark rounded-full w-20 pt-1">
                                    40%
                                </div>
                            </div>
                        </div> */}
                    </div>

                    <div className="mt-10">
                        <SoundWave
                            url={audioUrl}
                            id={"test"}
                            isWaveDisplay={true}
                            isTimeDisplay={false}
                        />
                    </div>
                </div>
            </div>{" "}
            {/*-----End--grid---- */}
            <div className="flex justify-center mt-5 gap-5">
                <SecondaryButton
                    onClick={nextStep}
                    className="capitalize xs:w-full xs:justify-center"
                >
                    Next <BsChevronRight className="text-lg ml-1" />
                </SecondaryButton>
            </div>
        </>
    );
};

export default SoundMixing;
