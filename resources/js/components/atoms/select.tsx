import { cn } from '@/lib/utils';

type Data = {
    label: string;
    value: string | number;
};
export default function Select({
    className,
    data,
    ...props
}: React.ComponentProps<'select'> & {
    data: Data[];
}) {
    return (
        <select
            className={cn(
                'text-text-main rounded-lg border border-secondary/20 bg-background px-2 py-1 text-xs transition-colors focus:border-primary focus:outline-none',
                className,
            )}
            {...props}
        >
            {data.map((item, index) => (
                <option key={index} value={item.value}>
                    {item.value}
                </option>
            ))}
        </select>
    );
}
