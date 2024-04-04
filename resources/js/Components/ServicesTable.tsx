import { Link } from "@inertiajs/react";
import { ServiceProps } from "./ServicePreview";

type Props = {
    services: ServiceProps[];
};

const ServicesTable = ({ services }: Props) => {
    return (
        <div className="flex flex-col">
            <div className="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                <div className="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div className="overflow-hidden">
                        <table className="min-w-full">
                            <thead className="bg-gray-200 border-b">
                                <tr>
                                    <th
                                        scope="col"
                                        className="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                                    >
                                        #
                                    </th>
                                    <th
                                        scope="col"
                                        className="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                                    >
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {services &&
                                    services.map((service) => (
                                        <tr className="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {service.id}
                                            </td>
                                            <td className="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <Link
                                                    href={route(
                                                        `service.preview`,
                                                        { id: service.id }
                                                    )}
                                                    className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-purple-700/70 hover:font-bold focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                                >
                                                    {service.name}
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ServicesTable;
