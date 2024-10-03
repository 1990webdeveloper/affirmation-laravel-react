import { useEffect, useState } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Link, usePage, Head } from "@inertiajs/react";
import {
    FaFacebookF,
    FaInstagram,
    FaTwitter,
    FaUserCircle,
} from "react-icons/fa";
import { HiOutlineMenuAlt1 } from "react-icons/hi";
import { MdLogout } from "react-icons/md";
import { AiOutlineUser } from "react-icons/ai";
import { BiLockOpen } from "react-icons/bi";
import { ToastContainer, toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
import Favicon from "../../images/favicon.png";

export default function Authenticated({ header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);
    const { user } = usePage().props.auth;
    const { flash } = usePage().props;

    useEffect(() => {
        if (flash.success) {
            toast.success(flash.success);
        } else if (flash.error) {
            toast.error(flash.error);
        }
    }, [flash]);

    return (
        <>
            <ToastContainer />
            <div className="min-h-screen bg-dark">
                <Head>
                    <link rel="icon" type="image/png" href={Favicon} />
                </Head>
                <nav className="bg-primary sticky top-0 z-10">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between h-20">
                            <div className="flex justify-between w-full ">
                                <div className="shrink-0 flex items-center">
                                    <Link href="/">
                                        <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                    </Link>
                                </div>

                                <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <NavLink
                                        href={route("affirmation.create")}
                                        active={route().current(
                                            "affirmation.create"
                                        )}
                                        className="text-black"
                                    >
                                        Record Your Affirmations
                                    </NavLink>
                                    <NavLink
                                        href={route("affirmation")}
                                        active={route().current("affirmation")}
                                    >
                                        My Affirmations
                                    </NavLink>
                                </div>
                            </div>
                            <div className="hidden sm:flex sm:items-center sm:ml-6">
                                <div className="ml-3 relative">
                                    {user && (
                                        <Dropdown>
                                            <Dropdown.Trigger>
                                                <span className="inline-flex rounded-md">
                                                    <button
                                                        type="button"
                                                        className=" inline-flex items-center px-3 py-2 text-sm rounded-md text-black bg-transparent font-semibold  hover:text-gray-900 focus:outline-none transition ease-in-out duration-150"
                                                    >
                                                        <FaUserCircle className="me-2" />{" "}
                                                        <span className="whitespace-nowrap">
                                                            {user?.name}
                                                        </span>
                                                    </button>
                                                </span>
                                            </Dropdown.Trigger>
                                            <Dropdown.Content className="p-2 ">
                                                {/* <Dropdown.Link
                                                    href={route(
                                                        "customer.profile"
                                                    )}
                                                    className="rounded flex items-center gap-2 whitespace-nowrap"
                                                >
                                                    <AiOutlineUser /> Profile
                                                </Dropdown.Link> */}
                                                <Dropdown.Link
                                                    href={route(
                                                        "change.password"
                                                    )}
                                                    className="rounded flex items-center gap-2 whitespace-nowrap"
                                                >
                                                    <BiLockOpen /> Change
                                                    Password
                                                </Dropdown.Link>
                                                <Dropdown.Link
                                                    href={route(
                                                        "customer.logout"
                                                    )}
                                                    method="post"
                                                    as="button"
                                                    className="rounded flex items-center gap-2 whitespace-nowrap"
                                                >
                                                    <MdLogout /> Logout
                                                </Dropdown.Link>
                                            </Dropdown.Content>
                                        </Dropdown>
                                    )}

                                    {!user && (
                                        <span className="inline-flex rounded-md">
                                            <Link
                                                href={route("customer.login")}
                                                type="button"
                                                className=" inline-flex items-center px-3 py-2 text-sm rounded-md text-black bg-transparent font-semibold  hover:text-gray-900 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <FaUserCircle className="me-1" />{" "}
                                                Login
                                            </Link>
                                        </span>
                                    )}
                                </div>
                            </div>

                            <div className="-mr-2 flex items-center sm:hidden">
                                <button
                                    onClick={() =>
                                        setShowingNavigationDropdown(
                                            (previousState) => !previousState
                                        )
                                    }
                                    className="whitespace-nowrap inline-flex items-center justify-center p-2 rounded-md text-black focus:outline-none  transition duration-150 ease-in-out"
                                >
                                    <HiOutlineMenuAlt1 className="text-3xl" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        className={
                            (showingNavigationDropdown ? "block" : "hidden") +
                            " sm:hidden"
                        }
                    >
                        <div className="pt-2 pb-3 space-y-1 bg-black">
                            <ResponsiveNavLink
                                href={route("affirmation")}
                                active={route().current("affirmation")}
                            >
                                My Affirmations
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                href={route("affirmation.create")}
                                active={route().current("affirmation.create")}
                            >
                                Record Your Affirmations
                            </ResponsiveNavLink>
                        </div>

                        <div className="pb-1 border-t border-gray-200 bg-black">
                            <div className="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    href={route("customer.profile")}
                                    className="flex items-center gap-2"
                                >
                                    <AiOutlineUser /> {user?.name}
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    method="post"
                                    href={route("customer.logout")}
                                    as="button"
                                    className="flex items-center gap-2"
                                >
                                    <MdLogout /> Logout
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </nav>

                {header && (
                    <header className="bg-white shadow">
                        <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                <main>{children}</main>

                <footer className="bg-box py-6">
                    <div className="text-white max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <Link
                            href={route("home")}
                            className="text-xs sm:text-sm mx-5 relative hover:opacity-80 transition-all after:absolute after:content after:-left-4 after:top-1.5 after:rounded after:w-2 after:h-2 after:bg-primary"
                        >
                            Home
                        </Link>
                        <Link
                            href={route("affirmation.create")}
                            className="text-xs sm:text-sm mx-5 relative hover:opacity-80 transition-all after:absolute after:content after:-left-4 after:top-1.5 after:rounded after:w-2 after:h-2 after:bg-primary"
                        >
                            Record Your Affirmations
                        </Link>
                        <Link
                            href={route("affirmation")}
                            className="text-xs sm:text-sm mx-5 relative hover:opacity-80 transition-all  after:absolute after:content after:-left-4 after:top-1.5 after:rounded after:w-2 after:h-2 after:bg-primary"
                        >
                            My Affirmations
                        </Link>
                        <Link
                            href="javascript:;"
                            className="text-xs sm:text-sm mx-5 relative hover:opacity-80 transition-all  after:absolute after:content after:-left-4 after:top-1.5 after:rounded after:w-2 after:h-2 after:bg-primary"
                        >
                            Blog
                        </Link>

                        <div className="flex items-center justify-between mt-3">
                            <div className="text-white text-xs sm:text-sm">
                                © 2023 MyAffirmations
                            </div>
                            <div className="text-white flex items-center justify-end gap-4">
                                <Link
                                    href="#!"
                                    className="text-gray-400 hover:text-gray-300 transition-all"
                                >
                                    <FaFacebookF />
                                </Link>
                                <Link
                                    href="#!"
                                    className="text-gray-400 hover:text-gray-300 transition-all"
                                >
                                    <FaInstagram />
                                </Link>
                                <Link
                                    href="#!"
                                    className="text-gray-400 hover:text-gray-300 transition-all"
                                >
                                    <FaTwitter />
                                </Link>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
