import { cn } from '@/lib/utils';

export default function Label({
    className,
    label,
}: React.ComponentProps<'div'> & {
    label: string;
}) {
    return (
        <span
            className={cn(
                'text-xs font-semibold tracking-wider uppercase opacity-80',
                className,
            )}
        >
            {label}
        </span>
    );
}
