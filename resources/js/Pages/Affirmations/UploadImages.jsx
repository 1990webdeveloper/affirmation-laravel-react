import React, { Component, useEffect, useState } from "react";

import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Checkbox from "../../Components/Checkbox";
import SecondaryButton from "../../Components/SecondaryButton";
import { BsChevronRight } from "react-icons/bs";
import { useForm } from "@inertiajs/react";

const UploadImages = (props) => {
    const currentStep = props.currentStep;
    const affirmation = props.affirmation;
    const [imagesData, setImageData] = useState([]);
    const [imagesFileObj, setImageFileObg] = useState([]);
    const [removeImages, setRemoveImages] = useState([]);

    const { data, setData, post, processing, errors, reset } = useForm({
        affirmation_id: affirmation?.id,
        is_transcription_display: false,
        effect_type: "",
        images: "",
        remove_images: "",
        step: currentStep,
    });

    const nextStep = (e) => {
        e.preventDefault();
        post(route("affirmation.store"), {
            onSuccess: () => {
                props.handleNextStep();
            },
        });
    };

    const uploadSingleFile = (e) => {
        for (let i = 0; i < e.target.files.length; i++) {
            const fileObj = new File(
                [e.target.files[i]],
                e.target.files[i].name,
                {
                    type: e.target.files[i].type,
                }
            );
            setImageFileObg((imagesFileObj) => [...imagesFileObj, fileObj]);
            setImageData((imagesData) => [
                ...imagesData,
                URL.createObjectURL(e.target.files[i]),
            ]);
        }
    };

    const removeImage = (e, key) => {
        e.preventDefault();
        setImageData(imagesData.filter((image, index) => index !== key));
        setImageFileObg(
            imagesFileObj.filter((imageFile, index) => index !== key)
        );
        const removedImage = imagesData.filter((image, index) => index === key);
        setRemoveImages((removeImages) => [...removeImages, removedImage[0]]);
    };

    const createFileObjectFromImageUrl = async (imageUrl) => {
        const response = await fetch(imageUrl);
        const blob = await response.blob();
        const filename = imageUrl.substring(imageUrl.lastIndexOf("/") + 1);
        const fileObj = new File([blob], filename, { type: blob.type });
        setImageFileObg((imagesFileObj) => [...imagesFileObj, fileObj]);
    };

    useEffect(() => {
        setData("images", imagesFileObj);
    }, [imagesFileObj]);

    useEffect(() => {
        setData({
            ...data,
            remove_images: removeImages,
            images: imagesFileObj,
        });
    }, [removeImages]);

    useEffect(() => {
        if (affirmation) {
            console.log("aa");
            if (affirmation?.images_url) {
                setImageData(affirmation?.images_url);
                affirmation?.images_url?.map((item, index) => {
                    createFileObjectFromImageUrl(item);
                });
            }

            setData({
                ...data,
                is_transcription_display:
                    affirmation.is_transcription_display == "0" ? false : true,
                effect_type: affirmation.effect_type,
            });
        }
    }, []);

    console.log("data", data);

    return (
        <>
            <div className="min-h-[calc(75vh-304px)]">
                <div className="grid grid-cols-12 md:grid-cols-8">
                    <div className="col-start-1 md:col-start-3 col-span-12 md:col-span-4 ">
                        <div className="mt-10">
                            <InputLabel
                                htmlFor="images"
                                value="Upload Images"
                                className="text-primary text-center"
                            />
                            <div className="flex w-full  items-center justify-center bg-grey-lighter">
                                <label className="px-6 pt-2 pb-1 flex flex-col items-center  bg-blue text-white rounded tracking-wide capitalize border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                    <span className="text-base leading-1">
                                        Choose File
                                    </span>
                                    <input
                                        type="file"
                                        name="images"
                                        className="hidden"
                                        multiple
                                        onChange={uploadSingleFile}
                                    />
                                </label>
                            </div>
                        </div>
                        <div className="mt-5 mx-auto xs:px-0 px-5 xs:py-0 py-2 lg:px-32 lg:pt-12">
                            <div className="flex flex-wrap md:-m-2 items-center justify-center">
                                {imagesData?.map((image, index) => (
                                    <div
                                        className="flex xs:w-1/2 w-1/3 flex-wrap"
                                        key={index}
                                    >
                                        <div className="w-full p-1 md:p-2">
                                            <img
                                                alt="gallery"
                                                className="block xs:h-28 h-32 w-full rounded-md object-cover object-center"
                                                src={image}
                                            />

                                            <button
                                                type="button"
                                                className="text-center text-gray-300 text-xs mt-3 py-1 px-3 border border-1 border-gray-300 rounded-full mx-auto block"
                                                onClick={(e) =>
                                                    removeImage(e, index)
                                                }
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                ))}
                                <InputError
                                    className="mt-2"
                                    message={errors.images}
                                />
                            </div>
                        </div>

                        <div className="flex flex-wrap mt-10 items-center justify-center gap-8">
                            <div className="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    className="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 bg-transparent before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] checked:focus:border-white  checked:focus:before:shadow-none  checked:hover:border-white checked:focus:ring-0 checked:focus:ring-offset-0 focus:ring-offset-0"
                                    type="radio"
                                    name="effect_type"
                                    value="kaleidoscope"
                                    onChange={(e) =>
                                        setData("effect_type", e.target.value)
                                    }
                                    checked={
                                        data.effect_type === "kaleidoscope"
                                    }
                                />
                                <label
                                    className="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-white"
                                    htmlFor="radioDefault01"
                                >
                                    Kaleidoscope Effect
                                </label>
                            </div>
                            <div className=" block   pl-[1.5rem]">
                                <input
                                    className="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 bg-transparent before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] checked:focus:border-white  checked:focus:before:shadow-none  checked:hover:border-white checked:focus:ring-0 checked:focus:ring-offset-0 focus:ring-offset-0"
                                    type="radio"
                                    name="effect_type"
                                    value="fade_in_fade_out"
                                    onChange={(e) =>
                                        setData("effect_type", e.target.value)
                                    }
                                    checked={
                                        data.effect_type === "fade_in_fade_out"
                                    }
                                />
                                <label
                                    className="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-white"
                                    htmlFor="radioDefault02"
                                >
                                    Fade-in / Fade-out effect
                                </label>
                            </div>
                            <InputError
                                className="mt-2"
                                message={errors.effect_type}
                            />
                        </div>

                        <div className="flex flex-wrap my-10 items-center justify-center gap-2">
                            <Checkbox
                                name="transcription_box"
                                onChange={(e) =>
                                    setData(
                                        "is_transcription_display",
                                        !data.is_transcription_display
                                    )
                                }
                                checked={data.is_transcription_display}
                            ></Checkbox>
                        </div>
                    </div>
                </div>{" "}
                {/*-----End--grid---- */}
            </div>
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

export default UploadImages;
