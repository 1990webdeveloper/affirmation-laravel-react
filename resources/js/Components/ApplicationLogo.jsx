import Logo from '../../images/logo.svg';

export default function ApplicationLogo(props) {
    return (

        <>
            {/* <h6 className="font-semibold text-sm sm:text-lg">MANIFESTMYAFFIRMATIONS.COM</h6>
            <p className="text-center text-sm sm:text-base">Create Your Reality</p> */}
            <img src={Logo} alt='logo' className='w-6/12 md:w-9/12 object-contain' />
        </>
    );
}
