export default function FieldSection({
    children,
}: React.ComponentProps<'div'>) {
    return <div className="flex flex-col gap-2">{children}</div>;
}
