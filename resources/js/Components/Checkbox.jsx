export default function Checkbox({ className = '', ...props }) {
    return (
        <>
        <input
            {...props}
            type="checkbox"
            className={
                "relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded border-2 border-solid border-neutral-300 bg-transparent before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full  checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] checked:focus:border-white  checked:focus:before:shadow-none  checked:hover:border-white checked:focus:ring-0 checked:focus:ring-offset-0 focus:ring-offset-0" +
                className
            }
        />
        <label htmlFor="checkbox" className="text-white cursor-pointer">Use your transcript in video</label>
        </>
    );
}
