import React, { Component, useEffect, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { BsChevronRight, BsCircleFill } from "react-icons/bs";
import RecordAffirmation from "./RecordAffirmation";
import SoundMixing from "./SoundMixing";
import UploadImages from "./UploadImages";
import PlayVideo from "./PlayVideo";
import SecondaryButton from "../../Components/SecondaryButton";
import { ToastContainer, toast } from "react-toastify";

const Affirmation = ({
    categories,
    affirmation,
    affirmations,
    binauralBeats,
    backgroundAudio,
}) => {
    const [currentStep, setCurrentStep] = useState(1);
    const [completedSteps, setCompletedSteps] = useState([1]);

    const data = [
        {
            id: 1,
            name: "Record Your Affirmations",
        },
        {
            id: 2,
            name: "Sound Mixing",
        },
        {
            id: 3,
            name: "Upload Images",
        },
        {
            id: 4,
            name: "Play Video",
        },
    ];

    const nextStep = () => {
        let newStep = currentStep + 1;
        setCurrentStep(newStep);
        setCompletedSteps([...completedSteps, newStep]);
        handleScrollTop();
    };

    const handleScrollTop = () => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth",
        });
    };

    const handleNextPrevious = (e, step) => {
        e.preventDefault();
        setCurrentStep(step);
        handleScrollTop();
        setCompletedSteps([...completedSteps, step]);
    };

    useEffect(() => {
        if (affirmation) {
            let newStep = parseInt(affirmation?.step) + parseInt(1);
            setCurrentStep(newStep);
            setCompletedSteps([...completedSteps, newStep]);
        }
    }, []);

    return (
        <AuthenticatedLayout>
            {data.map(
                (item, index) =>
                    item.id == currentStep && (
                        <Head key={index} title={item.name} />
                    )
            )}

            <div className="bg-blue text-white mt-10 mb-5 w-max block m-auto px-6 py-1 rounded">
                {data.map((item, index) => item.id == currentStep && item.name)}
            </div>

            {/* stepper--header */}
            <div className=" p-4 xs:mb-2 mb-14 max-w-2xl mx-auto w-11/12">
                <div className="flex items-center">
                    {data.map((item, index) => (
                        <React.Fragment key={item.id}>
                            <div
                                key={item.id}
                                className="flex items-center relative"
                            >
                                {completedSteps.some(
                                    (key) => item.id <= key
                                ) ? (
                                    <div
                                        onClick={(e) =>
                                            handleNextPrevious(e, item.id)
                                        }
                                        className="rounded-full flex items-center justify-center transition duration-500 ease-in-out h-8 w-8 py-3 border-2 border-primary cursor-pointer"
                                    >
                                        <BsCircleFill className="text-lg text-blue" />
                                    </div>
                                ) : (
                                    <div className="rounded-full flex items-center justify-center transition duration-500 ease-in-out h-8 w-8 py-3 border-2 border-gray-500"></div>
                                )}
                                <div className="absolute top-0 -ml-12 text-center mt-14 w-32 text-xs font-medium capitalize text-white xs:hidden">
                                    {item.name}
                                </div>
                            </div>
                            {item.id < 4 && (
                                <div className="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-500 mx-5"></div>
                            )}
                        </React.Fragment>
                    ))}
                </div>
            </div>
            {/* stepper---header--end */}

            <div className="max-w-7xl mx-auto xs:pt-0 py-6 px-4 sm:px-6 lg:px-8">
                <div className="rounded bg-box p-6 sm:p-10 xs:mb-2 mb-5">
                    {currentStep == 1 && (
                        <RecordAffirmation
                            currentStep={currentStep}
                            handleNextStep={nextStep}
                            categories={categories}
                            affirmation={affirmation}
                        />
                    )}

                    {currentStep == 2 && (
                        <SoundMixing
                            currentAffirmation={affirmation}
                            currentStep={currentStep}
                            handleNextStep={nextStep}
                            affirmationData={affirmations}
                            binauralBeats={binauralBeats}
                            backgroundAudio={backgroundAudio}
                        />
                    )}

                    {currentStep == 3 && (
                        <UploadImages
                            affirmation={affirmation}
                            currentStep={currentStep}
                            handleNextStep={nextStep}
                        />
                    )}

                    {currentStep == 4 && (
                        <PlayVideo
                            affirmation={affirmation}
                            currentStep={currentStep}
                        />
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Affirmation;
