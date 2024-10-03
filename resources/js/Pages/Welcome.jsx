import React, { useEffect, useState, Component } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import "react-responsive-carousel/lib/styles/carousel.min.css"; // requires a loader
import { Carousel } from "react-responsive-carousel";

import Slide from "../../images/slide.png";
import SecondaryButton from "../Components/SecondaryButton";
import { GiSoundWaves } from "react-icons/gi";

export default function Welcome({ banner, user, status, canResetPassword }) {
    const sliderCount = [0, 1, 2];
    return (
        <AuthenticatedLayout>
            <Head title="Home" />
            <Carousel
                showArrows={false}
                autoPlay
                className="home-carousel w-full"
            >
                {banner.map((value, index) => (
                    <div
                        key={index}
                        className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
                    >
                        <div className="flex justify-between items-center flex-wrap flex-col-reverse sm:flex-row ">
                            <div className=" sm:w-1/2 lg:w-1/4 text-center sm:text-left">
                                <h3 className="text-white text-xl sm:text-2xl font-bold ">
                                    {value.name}
                                </h3>
                                <p className=" text-white text-sm font-normal my-1 sm:my-3 max-w-[328px] w-full">
                                    {value.description}
                                </p>
                                <Link
                                    href={route("affirmation.create")}
                                    className="inline-flex items-center px-5 py-3 bg-primary border-0 rounded font-semibold text-black tracking-widest shadow-sm focus:outline-none  disabled:opacity-25 transition ease-in-out duration-150 text-center capitalize text-xs sm:text-sm  mt-3 mb-4 sm:mb-0 sm:mt-5"
                                >
                                    Get Started
                                </Link>
                            </div>
                            <div className="d-flex justify-center w-2/5">
                                <img src={value.banner} alt="img" />
                            </div>
                        </div>
                    </div>
                ))}
            </Carousel>

            {/* ---about---section */}

            <div className="py-5 flex flex-col items-center text-center min-h-[calc(60vh-200px)]">
                <GiSoundWaves className="text-primary text-5xl" />
                <h4 className="text-white text-lg uppercase font-bold">
                    About
                    <br /> MyAffirmations
                </h4>
                <p className="max-w-3xl w-4/5 m-auto text-white text-sm font-light my-5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </p>
            </div>
        </AuthenticatedLayout>
    );
}
