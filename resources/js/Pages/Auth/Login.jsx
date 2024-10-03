import { useEffect } from "react";
import Checkbox from "@/Components/Checkbox";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function Login({ status, canResetPassword, message }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });
    useEffect(() => {
        return () => {
            reset("password");
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route("customer.login"));
    };
    return (
        <AuthenticatedLayout>
            <Head title="Log in" />
            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
            <div className="min-h-[calc(100vh-185px)] flex items-center justify-between flex-row w-full">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-box py-12 my-10 w-full">
                    <div className="">
                        <h4 className="mb-5  text-center w-max mx-auto text-2xl font-semibold text-white uppercase relative after:absolute after:left-1/2 after:-bottom-2 after:border after:w-6 after:border-primary after:content">
                            Login
                        </h4>
                        <form onSubmit={submit}>
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="email"
                                    value="Your Email"
                                    className="text-white"
                                />

                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.email}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="password"
                                    value="Your Password"
                                    className="text-white"
                                />

                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="current-password"
                                    onChange={(e) =>
                                        setData("password", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.password}
                                    className="mt-2"
                                />
                            </div>
                            <div className="mt-4 text-right">
                                <Link
                                    href={route("forgot.password")}
                                    className="text-primary text-sm font-medium hover:opacity-80 transition-all"
                                >
                                    Forgot Password?
                                </Link>
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    className="w-full text-center capitalize"
                                    disabled={processing}
                                >
                                    Login
                                </PrimaryButton>
                            </div>
                            <div className="mt-6 flex items-center justify-center">
                                <p className="text-white text-sm me-2">
                                    Don't have an account?
                                </p>
                                <Link
                                    href={route("customer.register")}
                                    className="text-primary text-sm underline font-medium hover:opacity-80 transition-all"
                                >
                                    Sign up
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
