import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, ...props }, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <input
            {...props}
            type={type}
            className={
                ' bg-input outline-none border-none  focus:border-none focus:ring-0 focus:shadow-none focus:outline-0  rounded-md shadow-sm text-white' +
                className
            }
            ref={input}
        />
    );
});
