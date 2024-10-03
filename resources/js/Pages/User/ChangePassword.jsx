import { useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

const changePassword = ({ user, status }) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        old_password: "",
        new_password: "",
        confirm_password: "",
    });
    const submit = (e) => {
        e.preventDefault();
        post(route("change.password.submit"));
    };
    return (
        <AuthenticatedLayout>
            <Head title="change Password" />
            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
            <div className="min-h-[calc(100vh-185px)] flex items-center justify-between flex-row w-full">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-box py-12 my-10 w-full">
                    <div className="">
                        <h4 className="mb-5  text-center w-max mx-auto text-2xl font-semibold text-white uppercase relative after:absolute after:left-1/2 after:-bottom-2 after:border after:w-6 after:border-primary after:content">
                            Change password
                        </h4>
                        <form onSubmit={submit}>
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="old_password"
                                    value="Old Password"
                                    className="text-white"
                                />

                                <TextInput
                                    id="old_password"
                                    type="password"
                                    name="old_password"
                                    value={data.password}
                                    className="mt-1 block w-full text-white"
                                    isFocused={true}
                                    onChange={(e) =>
                                        setData("old_password", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.old_password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="new_password"
                                    value="New Password"
                                    className="text-white"
                                />

                                <TextInput
                                    id="new_password"
                                    type="password"
                                    name="new_password"
                                    value={data.new_password}
                                    className="mt-1 block w-full text-white"
                                    onChange={(e) =>
                                        setData("new_password", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.new_password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="confirm_password"
                                    value="Confirm New Password"
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

export default changePassword;
