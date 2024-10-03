import { useEffect, useState } from "react";
import Checkbox from "@/Components/Checkbox";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Register = ({ status, canResetPassword }) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        confirm_password: "",
        remember: false,
    });

    const { flash } = usePage().props;

    useEffect(() => {
        if (flash.success) {
            toast.success(flash.success);
        } else if (flash.error) {
            toast.error(flash.error);
        }
        return () => {
            reset("password");
        };
    }, [flash]);

    const submit = (e) => {
        e.preventDefault();
        post(route("customer.registerSubmit"), {
            onFinish: () => toast.success("Register successful!"),
            onError: () => toast.error("Something went wrong!"),
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Register" />
            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
            <div className="min-h-[calc(100vh-185px)] flex items-center justify-between flex-row w-full">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-box py-12 my-10 w-full">
                    <div className="">
                        <h4 className="mb-5  text-center w-max mx-auto text-2xl font-semibold text-white uppercase relative after:absolute after:left-1/2 after:-bottom-2 after:border after:w-6 after:border-primary after:content">
                            Create Account
                        </h4>
                        <form onSubmit={submit}>
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="name"
                                    value="Name"
                                    className="text-white"
                                />

                                <TextInput
                                    id="name"
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.name}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="email"
                                    value="Email Address"
                                    className="text-white"
                                />

                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="username"
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
                                    value="Password"
                                    className="text-white"
                                />

                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="username"
                                    onChange={(e) =>
                                        setData("password", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="confirm_password"
                                    value="Confirm Password"
                                    className="text-white"
                                />

                                <TextInput
                                    id="confirm_password"
                                    type="password"
                                    name="confirm_password"
                                    value={data.confirm_password}
                                    className="mt-1 block w-full text-white"
                                    autoComplete="current-confirm_password"
                                    onChange={(e) =>
                                        setData(
                                            "confirm_password",
                                            e.target.value
                                        )
                                    }
                                />

                                <InputError
                                    message={errors.confirm_password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    className="w-full text-center capitalize"
                                    disabled={processing}
                                >
                                    Signup
                                </PrimaryButton>
                            </div>
                            <div className="mt-6 flex items-center justify-center">
                                <p className="text-white text-sm me-2">
                                    Already have an account?
                                </p>
                                <Link
                                    href={route("customer.login")}
                                    className="text-primary text-sm underline font-medium hover:opacity-80 transition-all"
                                >
                                    Sign in
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Register;
