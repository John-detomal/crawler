import { LayoutDashboard } from 'lucide-react';

export default function List() {
    return (
        <ul className="p-2">
            <li className="inline-flex gap-2 bg-primary">
                <LayoutDashboard /> Dashboard
            </li>
        </ul>
    );
}
