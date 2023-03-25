import { useForm } from '@inertiajs/react';

function Search() {
    const { data, get, setData, } = useForm({ q: '' });

    const handleSubmit = (e) => {
        e.preventDefault();
        get('/', { q: data.q });
    };

    const handleInputChange = (e) => {
        setData('q', e.target.value);
    };

    return (
        <form onSubmit={handleSubmit} className="flex items-center space-x-4">
            <input
                type="text"
                name="q"
                value={data.q}
                onChange={handleInputChange}
                placeholder="Search"
                className="px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <button
                type="submit"
                className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                Search
            </button>
        </form>
    );
}

export default Search;
