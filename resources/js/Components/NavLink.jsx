import { Link } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={
                'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ' +
                (active
                    ? 'relative border-0 border-b-0 after:content after:absolute after:w-full after:h-[2px] after:bottom-5 after:bg-blue after:z-0'
                    : 'border-0 border-b-0  ') +
                className
            }
        >
            {children}
        </Link>
    );
}
