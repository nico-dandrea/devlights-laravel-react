import { useForm } from '@inertiajs/react';
import DealCard from '@/Components/DealCard';
import { useEffect, useState } from 'react';

function Search() {
    const { data, get, setData } = useForm({ q: '' });
    const [timerId, setTimerId] = useState(null);

    useEffect(() => {
        if (timerId) {
            clearTimeout(timerId);
        }
        if (data.q) {
            setTimerId(setTimeout(() => {
                getDeals();
            }, 500));
        }
    }, [data.q]);

    const getDeals = () => {
        get('/', { q: data.q, preserveState: true });
    }

    const handleInputChange = (e) => {
        setData('q', e.target.value);
    };

    return (
        <div className="flex items-center space-x-4">
            <input
                type="text"
                name="q"
                value={data.q}
                onChange={handleInputChange}
                placeholder="Search"
                className="px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
        </div>
    );
}

export default function DealsBoard({ deals }) {
    return (
        <div className="mt-8">
            <div className="flex justify-center mt-24 mb-8">
                <Search />
            </div>
            {!deals || !deals.data || deals.data.count === 0 ? (
                <div className="flex justify-center">There are no deals to show</div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    {deals.data.map((deal) => (
                        <DealCard key={deal.dealID} deal={deal} />
                    ))}
                </div>
            )}
        </div>
    );
}
