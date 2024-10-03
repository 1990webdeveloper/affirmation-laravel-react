import { useEffect } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

const ForgotPassword = () => {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
    });
    const submit = (e) => {
        e.preventDefault();
        post(route("customer.password.email"));
    };
    return (
        <AuthenticatedLayout>
            <Head title="Forgot Password" />

            <div className="min-h-[calc(100vh-185px)] flex items-center justify-between flex-row w-full">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 bg-box py-12 my-10 w-full">
                    <div className="">
                        <h4 className="mb-5  text-center w-max mx-auto text-2xl font-semibold text-white uppercase relative after:absolute after:left-1/2 after:-bottom-2 after:border after:w-6 after:border-primary after:content">
                            Forgot Password
                        </h4>
                        <form onSubmit={submit}>
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

export default ForgotPassword;
