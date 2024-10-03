import { useEffect } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

const ResetPassword = ({token}) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: "",
        confirm_password: "",
        token: token
    });
    const submit = (e) => {
        e.preventDefault();
        post(route("reset.password.submit"));
    };
    return (
        <AuthenticatedLayout>
            <Head title="Reset Password" />

            <div className="min-h-[calc(100vh-185px)] flex items-center justify-between flex-row w-full">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-box py-12 my-10 w-full">
                    <div className="">
                        <h4 className="mb-5  text-center w-max mx-auto text-2xl font-semibold text-white uppercase relative after:absolute after:left-1/2 after:-bottom-2 after:border after:w-6 after:border-primary after:content">
                            Hello! Welcome back
                        </h4>
                        <form onSubmit={submit}>
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
                                    isFocused={true}
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
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default ResetPassword;
