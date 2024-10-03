import React, { useEffect, useState } from "react";
import FileSaver from "file-saver";
import PrimaryButton from "@/Components/PrimaryButton";
import DangerButton from "../../Components/DangerButton";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import {
    BsFillMicFill,
    BsMicMuteFill,
    BsPauseCircle,
    BsPlayCircle,
    BsChevronRight,
} from "react-icons/bs";
import SoundWave from "./SoundWave";
import SpeechRecognition, {
    useSpeechRecognition,
} from "react-speech-recognition";

const AudioRecord = ({ handleRecordedData, errors, affirmation }) => {
    const [isRecording, setIsRecording] = useState(false);
    const [recorder, setRecorder] = useState(null);
    const [audioUrl, setAudioUrl] = useState(null);
    const [isPause, setIsPause] = useState(false);
    const [isListening, setIsListening] = useState(false);
    const [note, setNote] = useState(null);
    const [audioFile, setAudioFile] = useState(null);

    const startRecording = () => {
        setIsListening(true);
        navigator.mediaDevices
            .getUserMedia({ audio: true })
            .then((stream) => {
                const options = { mimeType: "audio/webm" };
                const recorder = new MediaRecorder(stream, options);
                recorder.start();
                setIsRecording(true);
                setRecorder(recorder);
                recorder.ondataavailable = (e) => {
                    const blob = e.data;
                    const url = URL.createObjectURL(blob);
                    setAudioUrl(url);
                    setIsRecording(false);
                    if (recorder.state === "recording") {
                        recorder.stop().then(() => {
                            FileSaver.saveAs(blob, "recording.mp3");
                        });
                    }
                };
            })
            .catch((error) => {
                console.error("Error while recording audio:", error);
            });
    };

    const pasueRecording = () => {
        setIsListening(false);
        setIsPause(true);
        recorder.pause();
    };

    const resumeRecording = () => {
        setIsListening(true);
        setIsPause(false);
        recorder.resume();
    };

    const stopRecording = () => {
        setIsListening(false);
        recorder.stop();
        recorder.ondataavailable = (e) => {
            const blob = e.data;
            const url = URL.createObjectURL(blob);
            setAudioUrl(url);
            setIsRecording(false);
            if (blob) {
                const fileObj = new File([blob], "sound.mp3", {
                    type: blob.type,
                });
                setAudioFile(fileObj);
            } else {
                console.error("Recording failed");
            }
        };
    };

    const {
        transcript,
        listening,
        resetTranscript,
        browserSupportsSpeechRecognition,
    } = useSpeechRecognition();

    const handleListen = () => {
        if (isListening) {
            SpeechRecognition.startListening({
                continuous: true,
                language: "en-US",
            });
        } else {
            SpeechRecognition.stopListening();
        }
    };

    const handleTranscriptionChange = (e) => {
        setNote(e.target.value);
        handleRecordedData(audioUrl, e.target.value, audioFile);
    };

    useEffect(() => {
        setNote(transcript);
    }, [transcript]);

    useEffect(() => {
        if (audioUrl) {
            handleRecordedData(audioUrl, note, audioFile);
        }
    }, [audioUrl]);

    useEffect(() => {
        handleListen();
    }, [isListening]);

    useEffect(() => {
        setNote(affirmation?.recorded_transcription);
        setAudioUrl(affirmation?.audio_url);
    }, []);

    return (
        <>
            <div className="text-xs text-gray-400 text-center max-w-sm w-full mx-auto mt-14">
                Click the “Allow” button to enable microphone access for
                recording your affirmations.
            </div>
            <div className="flex items-center justify-center mt-5 gap-3 sm:gap-5 xs:flex-wrap">
                {isRecording &&
                    (isPause ? (
                        <PrimaryButton
                            onClick={resumeRecording}
                            className="capitalize bg-orange-500 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-500"
                        >
                            <BsPlayCircle className="text-lg mr-2" /> Resume
                            recording
                        </PrimaryButton>
                    ) : (
                        <PrimaryButton
                            onClick={pasueRecording}
                            className="capitalize bg-orange-500 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-500"
                        >
                            <BsPauseCircle className="text-lg mr-2" /> Pause
                            recording
                        </PrimaryButton>
                    ))}
                {!isRecording ? (
                    <PrimaryButton
                        onClick={startRecording}
                        className="capitalize"
                    >
                        <BsFillMicFill className="text-lg mr-2" /> Start {audioUrl && "New "}
                        Recording
                    </PrimaryButton>
                ) : (
                    <DangerButton
                        onClick={stopRecording}
                        className="capitalize"
                    >
                        <BsMicMuteFill className="text-lg mr-2" /> Stop
                        Recording
                    </DangerButton>
                )}
            </div>
            {audioUrl?.length > 0 && (
                <SoundWave
                    url={audioUrl}
                    id={"test"}
                    isWaveDisplay={false}
                    isTimeDisplay={true}
                />
            )}
            
            <div className="mt-6 text-center">
                <InputLabel
                    htmlFor="text"
                    value="Transcription Box"
                    className="text-white uppercase font-semibold"
                />

                {note ? (
                    <textarea
                        value={note}
                        className="rounded max-w-xl w-full h-36 border-0 bg-input text-white focus:outline-none focus:border-0 focus:shadow-0 focus:ring-0"
                        onChange={handleTranscriptionChange}
                    ></textarea>
                ) : (
                    <textarea className="rounded max-w-xl w-full h-36 border-0 bg-input text-white focus:outline-none focus:border-0 focus:shadow-0 focus:ring-0"></textarea>
                )}
                <InputError className="mt-2" message={errors.recorded_audio} />
            </div>
        </>
    );
};

export default AudioRecord;
