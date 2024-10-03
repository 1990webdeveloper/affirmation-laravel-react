import { useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

const Profile = ({ status, canResetPassword }) => {
    return (
        <AuthenticatedLayout>
            <Head title="Profile" />

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
        </AuthenticatedLayout>
    );
};

export default Profile;
