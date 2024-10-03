import React, { Component, useEffect, useState } from "react";

import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import Selectbox from "../../Components/Selectbox";
import SecondaryButton from "../../Components/SecondaryButton";
import { BsChevronRight, BsSave } from "react-icons/bs";
import AudioRecord from "./AudioRecord";
import { useForm } from "@inertiajs/react";

const RecordAffirmation = (props) => {
    const categories = props.categories;
    const affirmation = props.affirmation;
    const currentStep = props.currentStep;

    const { data, setData, post, processing, errors, reset } = useForm({
        category_id: "",
        affirmation_id: affirmation?.id,
        name: "",
        recorded_audio: "",
        recorded_transcription: "",
        audio_file: "",
        step: currentStep,
    });

    const [activeCategory, setActiveCategory] = useState();
    const [isSaved, setIsSaved] = useState(false);

    const setRecordedData = (url, note, file) => {
        setData({
            ...data,
            recorded_audio: url,
            recorded_transcription: note,
            audio_file: file,
        });
    };

    const callNextStep = (e) => {
        e.preventDefault();
        if (isSaved) {
            props.handleNextStep();
        } else {
            post(route("affirmation.store"), {
                onSuccess: () => {
                    props.handleNextStep();
                },
            });
        }
    };

    const handleChangeCategory = (event) => {
        let categoryId = event.target.value;
        let activeCat = findCategory(categoryId);
        setActiveCategory(activeCat);
        setData("category_id", parseInt(categoryId));
    };

    const findCategory = (categoryId) => {
        return categories.find(
            (category) => category.id === parseInt(categoryId)
        );
    };

    const saveAffirmation = (e) => {
        e.preventDefault();
        post(route("affirmation.store"), {
            onSuccess: () => {
                setIsSaved(true);
            },
        });
    };

    useEffect(() => {
        if (!affirmation && categories.length > 0) {
            setActiveCategory(categories[0]);
            setData("category_id", categories[0].id);
        } else if (affirmation) {
            setActiveCategory(findCategory(affirmation.category_id));
            setData({
                ...data,
                category_id: affirmation.category_id,
                name: affirmation.name,
                recorded_audio: affirmation.audio_url,
                recorded_transcription: affirmation.recorded_transcription,
            });
        }
    }, []);

    return (
        <>
            <div className="text-white text-sm font-semibold">
                Affirmation Ideas
            </div>
            <div className="grid grid-cols-1 -xs:grid-cols-2 sm:grid-cols-2 gap-14">
                <div>
                    <div className="mt-4">
                        <InputLabel
                            htmlFor="email"
                            value="Select a affirmation category"
                            className="text-primary"
                        />

                        <Selectbox
                            name="affirmation_category"
                            className="minimal w-full cursor-pointer"
                            onChange={handleChangeCategory}
                            value={activeCategory?.id}
                        >
                            <option value="">Select category</option>

                            {categories.map((category, index) => (
                                <option key={index} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </Selectbox>

                        <InputError
                            className="mt-2"
                            message={errors.category_id}
                        />
                    </div>
                    <div className="mt-4">
                        <InputLabel
                            htmlFor="text"
                            value="Affirmation Name"
                            className="text-primary"
                        />

                        <TextInput
                            id="text"
                            type="text"
                            name="text"
                            placeholder="Add affirmation name"
                            className="mt-1 block w-full text-white"
                            autoComplete="false"
                            isFocused={true}
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>
                </div>
                <div>
                    <h4 className="text-primary text-sm font-medium">
                        {activeCategory?.name}
                    </h4>
                    <div
                        className="show-category-list list-disc pl-5 mt-3 text-white text-md font-light"
                        dangerouslySetInnerHTML={{
                            __html: activeCategory?.description,
                        }}
                    ></div>
                </div>
            </div>{" "}
            {/*-----End--grid---- */}
            {/* Audio Recorder Start*/}
            <AudioRecord
                handleRecordedData={setRecordedData}
                errors={errors}
                affirmation={affirmation}
            />
            {/* Audio Recorder End */}
            <div className="flex justify-center mt-5 gap-5">
                <button
                    onClick={saveAffirmation}
                    className="inline-flex items-center px-5 py-3 border-0 rounded text-sm font-semibold capitalize xs:w-full xs:justify-center bg-pink-700 text-white"
                >
                    Save <BsSave className="text-lg ml-2" />
                </button>
                <SecondaryButton
                    onClick={callNextStep}
                    className="capitalize xs:w-full xs:justify-center ml-3"
                >
                    Next <BsChevronRight className="text-lg ml-1" />
                </SecondaryButton>
            </div>
        </>
    );
};

export default RecordAffirmation;
