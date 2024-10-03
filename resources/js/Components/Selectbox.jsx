import { Children, forwardRef, useEffect, useRef } from 'react';

export default function Selectbox({ className = '', children, ...props }) {
    // const input = ref ? ref : useRef();

    // useEffect(() => {
    //     if (isFocused) {
    //         input.current.focus();
    //     }
    // }, []);

    return (
        <select
            className={
                ' bg-input outline-none border-none  focus:border-none focus:ring-0 focus:shadow-none focus:outline-0  rounded-md shadow-sm text-white' + ' ' +
                className
            }
            {...props}
        >
            {children}
        </select>

    );
};
