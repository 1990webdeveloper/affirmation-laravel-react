export default function InputLabel({ value, className = '', children, ...props }) {
    return (
        <label {...props} className={`block mb-3 font-normal text-sm  ` + className}>
            {value ? value : children}
        </label>
    );
}
