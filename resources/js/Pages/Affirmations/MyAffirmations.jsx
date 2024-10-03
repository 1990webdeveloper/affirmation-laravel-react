import React, { Component } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/react";
import { BsPauseCircleFill, BsPlayCircleFill } from "react-icons/bs";
import { RiFileEditFill, RiDeleteBinFill } from "react-icons/ri";
import { TbDownload } from "react-icons/tb";
import SoundWave from "./SoundWave";

const MyAffirmations = ({ affirmations }) => {
    const { user } = usePage().props.auth;
    return (
        <>
            <AuthenticatedLayout>
                <Head title="My Affirmations" />

                <div className="bg-blue text-white mt-10 mb-5 w-max block m-auto px-6 py-1 rounded">
                    My Affirmations
                </div>

                <div className="min-h-[calc(75vh-34px)]">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {affirmations.length == 0 && (
                            <div className="bg-box rounded my-2 p-5">
                                <div className="items-center text-center">
                                    <div className="border-1 border-b border-gray-600 sm:border-none pb-2 sm:pb-0">
                                        <h6 className="text-white text-sm font-medium">
                                            No Data Available
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        )}
                        {affirmations.map((affirmation, index) => (
                            <div
                                key={index}
                                className="bg-box rounded my-2 p-5"
                            >
                                {/* --start--list--1 */}
                                <div className="sm:flex items-center justify-between">
                                    <div className="border-1 border-b border-gray-600 sm:border-none pb-2 sm:pb-0">
                                        <h6 className="text-white text-sm font-medium">
                                            {affirmation.name}
                                        </h6>
                                        <p className="text-gray-300 text-xs mt-1">
                                            Last Modification :{" "}
                                            {affirmation.modification_date}
                                        </p>
                                    </div>

                                    <div className="flex items-center xs:justify-start justify-between sm:justify-start pt-2 sm:pt-0">
                                        <div className="flex items-center gap-4">
                                            <SoundWave
                                                url={
                                                    affirmation?.mixed_audio_url ??
                                                    affirmation?.audio_url
                                                }
                                                id={affirmation.id}
                                                isWaveDisplay={false}
                                                isTimeDisplay={true}
                                            />
                                        </div>
                                        <div className="text-blue text-5xl font-light overflow-hidden  mx-3">
                                            |
                                        </div>
                                        <div className="flex items-center gap-3">
                                            <Link
                                                href={route(
                                                    "affirmation.create",
                                                    affirmation.id
                                                )}
                                            >
                                                <div className="bg-input rounded-full w-9 h-9 flex items-center justify-center cursor-pointer">
                                                    <RiFileEditFill className="text-primary" />
                                                </div>
                                            </Link>
                                            <div className="bg-input rounded-full w-9 h-9 flex items-center justify-center cursor-pointer">
                                                <RiDeleteBinFill className="text-primary" />
                                            </div>
                                            <div className="bg-input rounded-full w-9 h-9 flex items-center justify-center cursor-pointer">
                                                <TbDownload className="text-primary" />
                                            </div>
                                        </div>
                                    </div>
                                </div>{" "}
                                {/* --end--list--1 */}
                            </div>
                        ))}
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
};

export default MyAffirmations;
